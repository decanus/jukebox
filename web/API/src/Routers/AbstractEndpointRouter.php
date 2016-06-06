<?php

namespace Jukebox\API\Routers
{

    use Jukebox\API\AccessControl;
    use Jukebox\API\Endpoints\EndpointInterface;
    use Jukebox\API\Exceptions\Forbidden;
    use Jukebox\Framework\Controllers\ControllerInterface;
    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\Routers\RouterInterface;

    abstract class AbstractEndpointRouter implements RouterInterface
    {
        /**
         * @var AccessControl
         */
        private $accessControl;

        /**
         * @var EndpointInterface[]
         */
        private $endpoints = [];

        public function __construct(AccessControl $accessControl)
        {
            $this->accessControl = $accessControl;
        }

        public function addEndpointHandler(EndpointInterface $endpoint)
        {
            $this->endpoints[$endpoint->getRequestType()][] = $endpoint;
        }

        public function route(RequestInterface $request): ControllerInterface
        {
            $type = get_class($request);

            if (!isset($this->endpoints[$type])) {
                throw new \InvalidArgumentException('No endpoint definition for "' . $type . '"');
            }

            foreach ($this->endpoints[$type] as $endpoint) {
                if (!$endpoint->isEndpoint($request)) {
                    continue;
                }

                if (!$this->accessControl->hasPermissions($request, $endpoint)) {
                    throw new Forbidden;
                }

                return $endpoint->handle($request);
            }

            throw new \InvalidArgumentException('Invalid "' . $this->getEndpoint() . '" API request');
        }

        abstract public function getEndpoint(): string;
    }
}

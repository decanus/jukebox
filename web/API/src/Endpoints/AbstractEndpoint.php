<?php

namespace Jukebox\API\Endpoints
{

    use Jukebox\Framework\Controllers\ControllerInterface;
    use Jukebox\Framework\Factories\MasterFactory;
    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\ValueObjects\Uri;

    abstract class AbstractEndpoint implements EndpointInterface
    {
        /**
         * @var MasterFactory
         */
        private $factory;

        public function __construct(MasterFactory $factory)
        {
            $this->factory = $factory;
        }

        public function handle(RequestInterface $request): ControllerInterface
        {
            if (!$this->validate($request->getUri())) {
                throw new \InvalidArgumentException('Cannot handle invalid request');
            }

            if (get_class($request) !== $this->getRequestType()) {
                throw new \InvalidArgumentException('Invalid request type for endpoint ' . $this->getApiEndpoint());
            }

            return $this->doHandle($request);
        }

        public function isEndpoint(RequestInterface $request): bool
        {
            return $this->validate($request->getUri());
        }

        protected function validate(Uri $uri): bool
        {
            $apiEndpoint = $this->getApiEndpoint();

            if (strpos($apiEndpoint, ':') === false) {
                return $apiEndpoint === $uri->getPath();
            }

            $explodedApiEndpoint = explode('/', ltrim($apiEndpoint, '/'));
            $explodedPath = $uri->getExplodedPath();

            if (count($explodedApiEndpoint) !== count($explodedPath)) {
                return false;
            }

            foreach ($explodedApiEndpoint as $partNumber => $urlPart) {
                if (strpos($urlPart, ':') !== false) {
                    continue;
                }

                if ($urlPart !== $explodedPath[$partNumber]) {
                    return false;
                }
            }

            return true;
        }

        protected function getFactory(): MasterFactory
        {
            return $this->factory;
        }

        abstract protected function doHandle(RequestInterface $request): ControllerInterface;
    }
}

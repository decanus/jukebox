<?php

namespace Jukebox\API\Routers
{

    use Jukebox\Framework\Factories\MasterFactory;
    use Jukebox\Framework\Http\Request\GetRequest;
    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\ParamterObjects\ControllerParameterObject;
    use Jukebox\Framework\Routers\RouterInterface;

    class GetRequestRouter implements RouterInterface
    {
        /**
         * @var MasterFactory
         */
        private $factory;

        public function __construct(MasterFactory $factory)
        {
            $this->factory = $factory;
        }

        /**
         * @param RequestInterface $request
         * 
         * @return \Jukebox\Framework\Controllers\ControllerInterface
         */
        public function route(RequestInterface $request)
        {
            if (!$request instanceof GetRequest) {
                return;
            }

            $uri = $request->getUri();
        }
    }
}

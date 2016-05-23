<?php

namespace Jukebox\API\Routers
{

    use Jukebox\Framework\Factories\MasterFactory;
    use Jukebox\Framework\Http\Request\PostRequest;
    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\ParamterObjects\ControllerParameterObject;
    use Jukebox\Framework\Routers\RouterInterface;

    class PostRequestRouter implements RouterInterface
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
            if (!$request instanceof PostRequest) {
                return;
            }

            $uri = $request->getUri();

            switch ($uri->getPath()) {
                case '/v1/auth':
                    return $this->factory->createAuthorizationController(new ControllerParameterObject($uri));
                case '/v1/register':
                    return $this->factory->createRegistrationController(new ControllerParameterObject($uri));
            }
        }
    }
}

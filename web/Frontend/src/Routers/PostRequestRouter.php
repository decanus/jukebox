<?php

namespace Jukebox\Frontend\Routers
{

    use Jukebox\Framework\Controllers\ControllerInterface;
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

        public function route(RequestInterface $request): ControllerInterface
        {
            if (!$request instanceof PostRequest) {
                throw new \InvalidArgumentException('No route found');
            }

            $uri = $request->getUri();
            
            switch ($uri->getPath()) {
                case '/action/login':
                    return $this->factory->createLoginRequestController(new ControllerParameterObject($uri));
                case '/action/register':
                    return $this->factory->createRegistrationRequestController(new ControllerParameterObject($uri));
            }

            throw new \InvalidArgumentException('No route found');
        }
    }
}

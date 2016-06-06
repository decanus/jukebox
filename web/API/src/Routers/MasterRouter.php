<?php

namespace Jukebox\API\Routers
{

    use Jukebox\API\Exceptions\NotFound;
    use Jukebox\Framework\Controllers\ControllerInterface;
    use Jukebox\Framework\Factories\MasterFactory;
    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\ParamterObjects\ControllerParameterObject;
    use Jukebox\Framework\Routers\RouterInterface;

    class MasterRouter implements RouterInterface
    {
        private $routers = [];

        /**
         * @var MasterFactory
         */
        private $factory;

        public function __construct(MasterFactory $factory)
        {
            $this->factory = $factory;
        }

        public function addRouter(AbstractEndpointRouter $router)
        {
            $endpoint = $router->getEndpoint();
            
            if (!isset($this->routers[$endpoint])) {
                $this->routers[$endpoint] = [];
            }

            $this->routers[$endpoint][spl_object_hash($router)] = $router;
        }

        public function route(RequestInterface $request): ControllerInterface
        {
            $uri = $request->getUri();
            $path = $uri->getPath();

            if ($path === '/') {
                return $this->factory->createIndexController(new ControllerParameterObject($uri));
            }

            $explodedPath = $uri->getExplodedPath();

            if (count($explodedPath) < 2 || !isset($this->routers[$explodedPath[1]])) {
                throw new NotFound('Not found');
            }

            $endpoint = $explodedPath[1];

            foreach ($this->routers[$endpoint] as $router) {
                $result = $router->route($request);

                if ($result instanceof ControllerInterface) {
                    return $result;
                }
            }

            throw new \Exception('No Controller returned');
        }
    }
}

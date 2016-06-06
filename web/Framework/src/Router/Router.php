<?php

namespace Jukebox\Framework\Routers
{

    use Jukebox\Framework\Controllers\ControllerInterface;
    use Jukebox\Framework\Http\Request\RequestInterface;

    class Router implements RouterInterface
    {
        /**
         * @var RouterInterface[]
         */
        private $routers = array();

        public function addRouter(RouterInterface $router)
        {
            $this->routers[] = $router;
        }

        public function route(RequestInterface $request): ControllerInterface
        {
            foreach ($this->routers as $router) {
                try {
                    return $router->route($request);
                } catch (\Exception $e) {
                    continue;
                }
            }

            throw new \Exception('No route found for "' . $request->getUri() . '"');
        }
    }
}

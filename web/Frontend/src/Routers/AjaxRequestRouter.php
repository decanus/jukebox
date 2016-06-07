<?php

namespace Jukebox\Frontend\Routers
{

    use Jukebox\Framework\Controllers\ControllerInterface;
    use Jukebox\Framework\Factories\MasterFactory;
    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\ParamterObjects\ControllerParameterObject;
    use Jukebox\Framework\Routers\RouterInterface;

    class AjaxRequestRouter implements RouterInterface
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
            $uri = $request->getUri();

            switch ($uri->getPath()) {
                case '/apr/search':
                    return $this->factory->createAjaxSearchController(new ControllerParameterObject($uri));
            }

            throw new \InvalidArgumentException('No ajax route found');
        }
    }
}
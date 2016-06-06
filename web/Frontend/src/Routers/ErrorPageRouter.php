<?php

namespace Jukebox\Frontend\Routers
{

    use Jukebox\Framework\Controllers\ControllerInterface;
    use Jukebox\Framework\Factories\MasterFactory;
    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\ParamterObjects\ControllerParameterObject;
    use Jukebox\Framework\Routers\RouterInterface;

    class ErrorPageRouter implements RouterInterface
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
            return $this->factory->createNotFoundPageController(new ControllerParameterObject($request->getUri()));
        }
    }
}

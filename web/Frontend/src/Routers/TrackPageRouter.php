<?php

namespace Jukebox\Frontend\Routers
{

    use Jukebox\Framework\DataPool\DataPoolReader;
    use Jukebox\Framework\Factories\MasterFactory;
    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\ParamterObjects\ControllerParameterObject;
    use Jukebox\Framework\Routers\RouterInterface;

    class TrackPageRouter implements RouterInterface
    {
        /**
         * @var MasterFactory
         */
        private $factory;

        /**
         * @var DataPoolReader
         */
        private $dataPoolReader;

        public function __construct(MasterFactory $factory, DataPoolReader $dataPoolReader)
        {

            $this->factory = $factory;
            $this->dataPoolReader = $dataPoolReader;
        }

        /**
         * @param RequestInterface $request
         *
         * @return \Jukebox\Framework\Controllers\ControllerInterface
         */
        public function route(RequestInterface $request)
        {
            $uri = $request->getUri();

            if (!$this->dataPoolReader->hasTrackIdForPath($uri->getPath())) {
                return;
            }

            return $this->factory->createTrackPageController(new ControllerParameterObject($uri));
        }
    }
}

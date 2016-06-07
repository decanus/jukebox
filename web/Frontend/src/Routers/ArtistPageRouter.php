<?php

namespace Jukebox\Frontend\Routers
{

    use Jukebox\Framework\Controllers\ControllerInterface;
    use Jukebox\Framework\DataPool\DataPoolReader;
    use Jukebox\Framework\Factories\MasterFactory;
    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\ParamterObjects\ControllerParameterObject;
    use Jukebox\Framework\Routers\RouterInterface;

    class ArtistPageRouter implements RouterInterface
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

        public function route(RequestInterface $request): ControllerInterface
        {
            $uri = $request->getUri();
            
            if (!$this->dataPoolReader->hasArtistIdForPath($uri->getPath())) {
                throw new \InvalidArgumentException('Artist not found');
            }

            return $this->factory->createArtistPageController(new ControllerParameterObject($uri));
        }
    }
}

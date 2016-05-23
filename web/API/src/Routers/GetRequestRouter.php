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

            switch ($uri->getPath()) {
                case '/v1/search':
                    return $this->factory->createSearchController(new ControllerParameterObject($uri));
            }

            $path = $uri->getExplodedPath();

            if (count($path) === 3 && $path[0] === 'v1' && $path[1] === 'artists' && is_numeric($path[2])) {
                return $this->factory->createGetArtistController(new ControllerParameterObject($uri));
            }

            if (count($path) === 4 && $path[0] === 'v1' && $path[1] === 'artists' && is_numeric($path[2]) && $path[3] === 'tracks') {
                return $this->factory->createGetArtistTracksController(new ControllerParameterObject($uri));
            }
        }
    }
}

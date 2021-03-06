<?php

namespace Jukebox\API\Endpoints\v1\Artists\Tracks
{

    use Jukebox\API\Endpoints\AbstractEndpoint;
    use Jukebox\Framework\Controllers\ControllerInterface;
    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\ParamterObjects\ControllerParameterObject;

    class GetArtistTracksEndpoint extends AbstractEndpoint
    {
        protected function doHandle(RequestInterface $request): ControllerInterface
        {
            return $this->getFactory()->createGetArtistTracksController(new ControllerParameterObject($request->getUri()));
        }

        public function getApiEndpoint(): string
        {
            return '/v1/artists/:artist/tracks';
        }

        public function requiresAccessToken(): bool
        {
            return false;
        }

        public function getRequestType(): string
        {
            return \Jukebox\Framework\Http\Request\GetRequest::class;
        }
    }
}

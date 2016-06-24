<?php

namespace Jukebox\API\Endpoints\v1\Users\Playlists
{

    use Jukebox\API\Endpoints\AbstractEndpoint;
    use Jukebox\Framework\Controllers\ControllerInterface;
    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\ParamterObjects\ControllerParameterObject;

    class GetUserPlaylistsEndpoint extends AbstractEndpoint
    {

        protected function doHandle(RequestInterface $request): ControllerInterface
        {
            return $this->getFactory()->createGetPlaylistController(new ControllerParameterObject($request->getUri()));
        }

        public function getApiEndpoint(): string
        {
            return '/v1/users/:user/playlists';
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

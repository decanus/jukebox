<?php

namespace Jukebox\API\Endpoints\v1\Users\Playlists
{

    use Jukebox\API\Endpoints\AbstractEndpoint;
    use Jukebox\Framework\Controllers\ControllerInterface;
    use Jukebox\Framework\Http\Request\RequestInterface;

    class GetUserPlaylistEndpoint extends AbstractEndpoint
    {

        protected function doHandle(RequestInterface $request): ControllerInterface
        {
            // TODO: Implement doHandle() method.
        }

        public function getApiEndpoint(): string
        {
            return '/v1/users/:user/playlists/:playlist';
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

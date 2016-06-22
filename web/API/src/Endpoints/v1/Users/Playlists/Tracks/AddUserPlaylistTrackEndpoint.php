<?php

namespace Jukebox\API\Endpoints\v1\Users\Playlists\Tracks
{

    use Jukebox\API\Endpoints\AbstractEndpoint;
    use Jukebox\Framework\Controllers\ControllerInterface;
    use Jukebox\Framework\Http\Request\RequestInterface;

    class AddUserPlaylistTrackEndpoint extends AbstractEndpoint
    {
        protected function doHandle(RequestInterface $request): ControllerInterface
        {
            // TODO: Implement doHandle() method.
        }

        public function getApiEndpoint(): string
        {
            return '/v1/users/:user/playlists/:playlist/tracks';
        }

        public function requiresAccessToken(): bool
        {
            return false;
        }

        public function getRequestType(): string
        {
            return \Jukebox\Framework\Http\Request\PostRequest::class;
        }
    }
}

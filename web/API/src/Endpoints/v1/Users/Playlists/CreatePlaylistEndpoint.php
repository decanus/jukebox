<?php

namespace Jukebox\API\Endpoints\v1\Users\Playlists
{

    use Jukebox\API\Endpoints\AbstractEndpoint;
    use Jukebox\Framework\Controllers\ControllerInterface;
    use Jukebox\Framework\Http\Request\RequestInterface;

    class CreatePlaylistEndpoint extends AbstractEndpoint
    {

        protected function doHandle(RequestInterface $request): ControllerInterface
        {
            // TODO: Implement doHandle() method.
        }

        public function getApiEndpoint(): string
        {
            return '/v1/users/:user/playlists';
        }

        public function requiresAccessToken(): bool
        {
            return true;
        }

        public function getRequestType(): string
        {
            return \Jukebox\Framework\Http\Request\PostRequest::class;
        }
    }
}

<?php

namespace Jukebox\API\Routers
{
    class UsersRouter extends AbstractEndpointRouter
    {

        public function getEndpoint(): string
        {
            return 'users';
        }
    }
}

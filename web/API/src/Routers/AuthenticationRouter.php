<?php

namespace Jukebox\API\Routers
{
    class AuthenticationRouter extends AbstractEndpointRouter
    {

        public function getEndpoint(): string
        {
            return 'authentication';
        }
    }
}

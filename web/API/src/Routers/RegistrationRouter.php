<?php

namespace Jukebox\API\Routers
{
    class RegistrationRouter extends AbstractEndpointRouter
    {
        public function getEndpoint(): string
        {
            return 'register';
        }
    }
}

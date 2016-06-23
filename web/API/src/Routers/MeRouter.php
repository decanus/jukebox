<?php

namespace Jukebox\API\Routers
{
    class MeRouter extends AbstractEndpointRouter
    {

        public function getEndpoint(): string
        {
            return 'me';
        }
    }
}

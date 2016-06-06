<?php

namespace Jukebox\API\Routers
{
    class TracksRouter extends AbstractEndpointRouter
    {
        public function getEndpoint(): string
        {
            return 'tracks';
        }
    }
}

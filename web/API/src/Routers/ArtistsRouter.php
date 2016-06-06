<?php

namespace Jukebox\API\Routers
{
    class ArtistsRouter extends AbstractEndpointRouter
    {
        public function getEndpoint(): string
        {
            return 'artists';
        }
    }
}

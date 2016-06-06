<?php

namespace Jukebox\API\Routers
{
    class SearchRouter extends AbstractEndpointRouter
    {
        public function getEndpoint(): string
        {
            return 'search';
        }
    }
}

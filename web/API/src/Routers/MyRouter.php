<?php

namespace Jukebox\API\Routers
{

    class MyRouter extends AbstractEndpointRouter
    {

        public function getEndpoint(): string
        {
            return 'me';
        }
    }
}

<?php

namespace Jukebox\API\Exceptions
{
    class Forbidden extends AbstractException
    {

        public function getStatusCode(): int
        {
            return 403;
        }
    }
}

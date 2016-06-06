<?php

namespace Jukebox\API\Exceptions
{
    class NotFound extends AbstractException
    {

        public function getStatusCode(): int
        {
            return 404;
        }
    }
}

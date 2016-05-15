<?php

namespace Jukebox\API\Exceptions
{
    class BadRequest extends AbstractException
    {

        public function getStatusCode(): int
        {
            return 400;
        }
    }
}

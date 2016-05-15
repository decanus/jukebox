<?php

namespace Jukebox\API\Exceptions
{
    abstract class AbstractException extends \Exception
    {
        abstract public function getStatusCode(): int;
    }
}

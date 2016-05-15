<?php

namespace Jukebox\Framework\Logging
{

    use Jukebox\Framework\Logging\Loggers\LoggerInterface;

    interface LoggerAware
    {
        public function setLogger(LoggerInterface $logger);

        public function getLogger(): LoggerInterface;
    }
}

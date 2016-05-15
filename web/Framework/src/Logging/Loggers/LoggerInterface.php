<?php


namespace Jukebox\Framework\Logging\Loggers
{

    use Jukebox\Framework\Logging\Logs\LogInterface;

    interface LoggerInterface
    {
        public function log(LogInterface $log);
    }
}

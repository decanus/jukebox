<?php

namespace Jukebox\Framework\Logging\Loggers
{

    use Jukebox\Framework\Logging\Logs\LogInterface;

    class NSALogger extends AbstractLogger
    {

        protected function getTypes(): array
        {
            return [\Jukebox\Framework\Logging\Logs\LogInterface::class];
        }

        public function log(LogInterface $log)
        {
            error_log(json_encode($log->getLog()));
        }
    }
}

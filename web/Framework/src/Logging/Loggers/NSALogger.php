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
            file_put_contents('/var/log/jukebox.log', (string) $log, FILE_APPEND);
        }
    }
}

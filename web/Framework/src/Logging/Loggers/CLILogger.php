<?php

namespace Jukebox\Framework\Logging\Loggers
{

    use Jukebox\Framework\Logging\Logs\LogInterface;

    class CLILogger extends AbstractLogger
    {

        protected function getTypes(): array
        {
            return [
                \Jukebox\Framework\Logging\Logs\LogInterface::class,
            ];
        }

        public function log(LogInterface $log)
        {
            echo $log->getMessage() . PHP_EOL;
        }
    }
}

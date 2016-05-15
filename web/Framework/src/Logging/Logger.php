<?php

namespace Jukebox\Framework\Logging
{

    use Jukebox\Framework\Logging\Loggers\AbstractLogger;
    use Jukebox\Framework\Logging\Loggers\LoggerInterface;
    use Jukebox\Framework\Logging\Logs\LogInterface;

    class Logger implements LoggerInterface
    {
        /**
         * @var AbstractLogger[]
         */
        private $loggers = [];
        
        
        public function addLogger(AbstractLogger $logger)
        {
            $this->loggers[] = $logger;
        }
        
        public function log(LogInterface $log)
        {
            foreach ($this->loggers as $logger) {
                if (!$logger->handles($log)) {
                    continue;
                }
                
                $logger->log($log);
            }
        }
    }
}

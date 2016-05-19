<?php

namespace Jukebox\Framework\Logging
{

    use Jukebox\Framework\Logging\Loggers\AbstractLogger;
    use Jukebox\Framework\Logging\Loggers\LoggerInterface;
    use Jukebox\Framework\Logging\Logs\CriticalLog;
    use Jukebox\Framework\Logging\Logs\EmergencyLog;
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

        public function emergency(\Throwable $e)
        {
            $this->log(new EmergencyLog($e));
        }

        public function critical(\Throwable $e)
        {
            $this->log(new CriticalLog($e));
        }

        public function alert(\Throwable $e)
        {

        }

        public function error(\Throwable $e)
        {

        }

        public function warning(\Throwable $e)
        {

        }

        public function notice(\Throwable $e)
        {

        }

        public function debug(\Throwable $e)
        {

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

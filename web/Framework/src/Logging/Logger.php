<?php

namespace Jukebox\Framework\Logging
{

    use Jukebox\Framework\Logging\Loggers\AbstractLogger;
    use Jukebox\Framework\Logging\Loggers\LoggerInterface;
    use Jukebox\Framework\Logging\Logs\AlertLog;
    use Jukebox\Framework\Logging\Logs\CriticalLog;
    use Jukebox\Framework\Logging\Logs\DebugLog;
    use Jukebox\Framework\Logging\Logs\EmergencyLog;
    use Jukebox\Framework\Logging\Logs\ErrorLog;
    use Jukebox\Framework\Logging\Logs\LogInterface;
    use Jukebox\Framework\Logging\Logs\NoticeLog;
    use Jukebox\Framework\Logging\Logs\WarningLog;

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
            $this->log(new AlertLog($e));
        }

        public function error(\Throwable $e)
        {
            $this->log(new ErrorLog($e));
        }

        public function warning(\Throwable $e)
        {
            $this->log(new WarningLog($e));
        }

        public function notice(\Throwable $e)
        {
            $this->log(new NoticeLog($e));
        }

        public function debug(\Throwable $e)
        {
            $this->log(new DebugLog($e));
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

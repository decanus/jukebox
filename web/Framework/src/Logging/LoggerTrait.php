<?php

namespace Jukebox\Framework\Logging
{

    use Jukebox\Framework\Logging\Loggers\LoggerInterface;
    use Jukebox\Framework\Logging\Logs\CriticalLog;
    use Jukebox\Framework\Logging\Logs\EmergencyLog;
    use Jukebox\Framework\Logging\Logs\LogInterface;

    trait LoggerTrait
    {
        /**
         * @var LoggerInterface
         */
        private $logger;

        public function setLogger(LoggerInterface $logger)
        {
            $this->logger = $logger;
        }

        public function getLogger(): LoggerInterface
        {
            return $this->logger;
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

        private function log(LogInterface $log)
        {
            $logger = $this->getLogger();
            if ($logger === null) {
                throw new \RuntimeException('No Logger set');
            }

            $logger->log($log);
        }
    }
}

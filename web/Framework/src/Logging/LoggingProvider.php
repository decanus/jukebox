<?php

namespace Jukebox\Framework\Logging
{

    use Jukebox\Framework\Logging\Loggers\LoggerInterface;
    use Jukebox\Framework\Logging\Logs\EmergencyLog;
    use Jukebox\Framework\Logging\Logs\LogInterface;

    trait LoggingProvider
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

        public function logEmergency(\Throwable $e)
        {
            $this->log(new EmergencyLog($e));
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

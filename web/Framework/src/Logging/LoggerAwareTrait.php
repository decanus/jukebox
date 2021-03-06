<?php

namespace Jukebox\Framework\Logging
{

    use Jukebox\Framework\Logging\Loggers\LoggerInterface;

    trait LoggerAwareTrait
    {
        /**
         * @var LoggerInterface
         */
        private $logger;

        public function setLogger(LoggerInterface $logger)
        {
            $this->logger = $logger;
        }

        protected function getLogger(): Logger
        {
            return $this->logger;
        }
    }
}

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

        public function getLogger(): LoggerInterface
        {
            return $this->logger;
        }
    }
}

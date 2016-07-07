<?php

namespace Jukebox\Backend\Factories
{
    class LoggerFactory extends \Jukebox\Framework\Factories\LoggerFactory
    {

        public function createLoggers(): \Jukebox\Framework\Logging\Logger
        {
            $logger = $this->createLogger();
            $logger->addLogger($this->createSlackLogger());
            return $logger;
        }

    }
}

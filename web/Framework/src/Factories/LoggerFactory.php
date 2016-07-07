<?php

namespace Jukebox\Framework\Factories
{

    use Jukebox\Framework\ValueObjects\Uri;

    class LoggerFactory extends AbstractFactory
    {
        /**
         * @var \Jukebox\Framework\Logging\Logger
         */
        private $logger;

        public function createLogger(): \Jukebox\Framework\Logging\Logger
        {
            if ($this->logger === null) {
                $this->logger = new \Jukebox\Framework\Logging\Logger;
            }

            return $this->logger;
        }

        public function createLoggers(): \Jukebox\Framework\Logging\Logger
        {
            $logger = $this->createLogger();
            $logger->addLogger($this->createSlackLogger());
            $logger->addLogger($this->createNSALogger());
            return $logger;
        }

        public function createNSALogger(): \Jukebox\Framework\Logging\Loggers\NSALogger
        {
            return new \Jukebox\Framework\Logging\Loggers\NSALogger;
        }

        public function createSlackLogger()
        {
            return new  \Jukebox\Framework\Logging\Loggers\SlackLogger(
                $this->getMasterFactory()->createCurl(),
                new Uri($this->getMasterFactory()->getConfiguration()->get('slackEndpoint')),
                $this->getMasterFactory()->getConfiguration()->isDevelopmentMode()
            );
        }
    }
}

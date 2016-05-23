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
            return $logger;
        }

        public function createCLILogger(): \Jukebox\Framework\Logging\Loggers\CLILogger
        {
            return new \Jukebox\Framework\Logging\Loggers\CLILogger;
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

<?php

namespace Jukebox\Framework\Logging\Loggers
{

    use Jukebox\Framework\Curl\Curl;
    use Jukebox\Framework\Logging\Logs\LogInterface;
    use Jukebox\Framework\ValueObjects\Uri;

    class SlackLogger extends AbstractLogger
    {
        /**
         * @var Curl
         */
        private $curl;

        /**
         * @var Uri
         */
        private $slackEndpoint;

        /**
         * @var bool
         */
        private $isDevelopment;

        public function __construct(Curl $curl, Uri $slackEndpoint, bool $isDevelopment = false)
        {
            $this->curl = $curl;
            $this->isDevelopment = $isDevelopment;
            $this->slackEndpoint = $slackEndpoint;
        }

        protected function getTypes(): array
        {
            if ($this->isDevelopment) {
                return [];
            }

            return [
                \Jukebox\Framework\Logging\Logs\EmergencyLog::class
            ];
        }

        public function log(LogInterface $log)
        {
            try {
                $this->curl->post(
                    $this->slackEndpoint,
                    ['payload' => json_encode([
                            'channel' => '#Jukeboxly-logging',
                            'username' => 'Jukeboxly',
                            'text' => $log->getMessage()
                        ])
                    ]
                );
            } catch (\Throwable $e) {
                // dont do shit
            }
        }
    }
}

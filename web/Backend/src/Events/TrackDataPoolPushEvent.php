<?php

namespace Jukebox\Backend\Events
{

    use Jukebox\Framework\Events\EventInterface;
    use Jukebox\Framework\ValueObjects\DataVersion;

    class TrackDataPoolPushEvent implements EventInterface
    {
        /**
         * @var DataVersion
         */
        private $dataVersion;

        /**
         * @var string
         */
        private $trackId;

        public function __construct(DataVersion $dataVersion, string $trackId)
        {
            $this->trackId = $trackId;
            $this->dataVersion = $dataVersion;
        }

        public function getName(): string
        {
            return 'TrackDataPoolPush';
        }

        public function getTrackId(): string
        {
            return $this->trackId;
        }

        public function getDataVersion(): DataVersion
        {
            return $this->dataVersion;
        }
    }
}

<?php

namespace Jukebox\Backend\Events
{

    use Jukebox\Framework\Events\EventInterface;

    class TrackDataPoolPushEvent implements EventInterface
    {
        /**
         * @var string
         */
        private $trackId;

        public function __construct(string $trackId)
        {
            $this->trackId = $trackId;
        }

        public function getName(): string
        {
            return 'TrackDataPoolPush';
        }

        public function getTrackId(): string
        {
            return $this->trackId;
        }
    }
}

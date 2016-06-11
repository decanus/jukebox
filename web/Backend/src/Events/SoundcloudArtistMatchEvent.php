<?php

namespace Jukebox\Backend\Events
{

    use Jukebox\Framework\Events\EventInterface;

    class SoundcloudArtistMatchEvent implements EventInterface
    {
        /**
         * @var string
         */
        private $artistId;

        public function __construct(string $artistId)
        {
            $this->artistId = $artistId;
        }

        public function getArtistId(): string
        {
            return $this->artistId;
        }

        public function getName(): string
        {
            return 'SoundcloudArtistMatch';
        }
    }
}

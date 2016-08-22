<?php

namespace Jukebox\Backend\Events
{

    use Jukebox\Framework\Events\EventInterface;

    class SoundcloudArtistImportEvent implements EventInterface
    {
        /**
         * @var string
         */
        private $soundcloudId;

        public function __construct(string $soundcloudId)
        {
            $this->soundcloudId = $soundcloudId;
        }

        public function getName(): string
        {
            return 'SoundcloudArtistImport';
        }

        public function getSoundcloudId(): string
        {
            return $this->soundcloudId;
        }
    }
}

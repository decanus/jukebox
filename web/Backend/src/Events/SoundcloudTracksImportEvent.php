<?php

namespace Jukebox\Backend\Events
{

    use Jukebox\Framework\Events\EventInterface;

    class SoundcloudTracksImportEvent implements EventInterface
    {
        /**
         * @var string
         */
        private $soundcloudId;

        public function __construct(string $soundcloudId)
        {
            $this->soundcloudId = $soundcloudId;
        }

        public function getSoundcloudId(): string
        {
            return $this->soundcloudId;
        }

        public function getName(): string
        {
            return 'SoundcloudTracksImport';
        }
    }
}

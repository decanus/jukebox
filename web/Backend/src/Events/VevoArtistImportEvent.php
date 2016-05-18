<?php

namespace Jukebox\Backend\Events
{

    use Jukebox\Framework\Events\EventInterface;

    class VevoArtistImportEvent implements EventInterface
    {
        /**
         * @var string
         */
        private $artist;

        public function __construct(string $artist)
        {
            $this->artist = $artist;
        }

        public function getName(): string
        {
            return 'VevoArtistImport';
        }

        public function getArtist(): string
        {
            return $this->artist;
        }
    }
}

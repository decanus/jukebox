<?php

namespace Jukebox\Frontend\Models
{

    use Jukebox\Framework\Models\AbstractModel;

    class ArtistPageModel extends AbstractModel
    {
        /**
         * @var array
         */
        private $artist;

        /**
         * @var array
         */
        private $tracks;

        public function setArtist(array $artist)
        {
            $this->artist = $artist;
        }

        public function getArtist(): array
        {
            return $this->artist;
        }

        public function setTracks(array $tracks)
        {
            $this->tracks = $tracks;
        }

        public function getTracks(): array
        {
            return $this->tracks;
        }
    }
}

<?php

namespace Jukebox\Framework\DataPool
{
    class DataPoolReader extends AbstractDataPool
    {
        public function hasTrackIdForPath(string $path): bool 
        {
            return $this->hhas($this->getVersion(), $this->getKeyGenerator()->generateTrackIdFromPathKey($path));
        }

        public function getTrackIdForPath(string $path): string
        {
            return $this->hget($this->getVersion(), $this->getKeyGenerator()->generateTrackIdFromPathKey($path));
        }
        
        public function hasArtistIdForPath(string $path): bool 
        {
            return $this->hhas($this->getVersion(), $this->getKeyGenerator()->generateArtistIdFromPathKey($path));
        }

        public function getArtistIdForPath(string $path): string
        {
            return $this->hget($this->getVersion(), $this->getKeyGenerator()->generateArtistIdFromPathKey($path));
        }

        public function hasArtist(string $id): string
        {
            return $this->hhas($this->getVersion(), $this->getKeyGenerator()->generateArtistKey($id));
        }

        public function getArtist(string $id): array
        {
            return json_decode($this->hget($this->getVersion(), $this->getKeyGenerator()->generateArtistKey($id)), true);
        }

        public function hasTrack(string $id): string
        {
            return $this->hhas($this->getVersion(), $this->getKeyGenerator()->generateTrackKey($id));
        }

        public function getTrack(string $id): array
        {
            return json_decode($this->hget($this->getVersion(), $this->getKeyGenerator()->generateTrackKey($id)), true);
        }
    }
}

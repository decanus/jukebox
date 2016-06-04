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
    }
}

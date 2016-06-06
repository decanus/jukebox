<?php

namespace Jukebox\Framework\DataPool
{
    class DataPoolWriter extends AbstractDataPool
    {
        public function setTrackIdForPath(string $path, string $id)
        {
            $this->hset((string) $this->getVersion(), $this->getKeyGenerator()->generateTrackIdFromPathKey($path), $id);
        }

        public function setArtistIdForPath(string $path, string $id)
        {
            $this->hset((string) $this->getVersion(), $this->getKeyGenerator()->generateArtistIdFromPathKey($path), $id);
        }
    }
}
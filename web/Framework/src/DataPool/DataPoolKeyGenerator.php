<?php

namespace Jukebox\Framework\DataPool
{
    class DataPoolKeyGenerator
    {
        public function generateTrackIdFromPathKey(string $path): string
        {
            return 'tidfp_' . $path;
        }

        public function generateArtistIdFromPathKey(string $path): string
        {
            return 'aidfp_' . $path;
        }
    }
}

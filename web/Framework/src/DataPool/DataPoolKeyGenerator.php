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

        public function generateArtistKey(string $id): string
        {
            return 'ak_' . $id;
        }

        public function generateTrackKey(string $id): string
        {
            return 'tk_' . $id;
        }
    }
}

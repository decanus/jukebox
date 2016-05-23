<?php

namespace Jukebox\Framework\ValueObjects
{
    class Featured implements ArtistRole
    {

        public function __toString(): string
        {
            return 'featured';
        }
    }
}

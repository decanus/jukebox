<?php

namespace Jukebox\Framework\ValueObjects
{
    class Main implements ArtistRole
    {

        public function __toString(): string
        {
            return 'main';
        }
    }
}

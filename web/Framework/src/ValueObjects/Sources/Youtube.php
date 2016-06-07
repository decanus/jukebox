<?php

namespace Jukebox\Framework\ValueObjects\Sources
{

    class Youtube implements Source
    {

        public function __toString(): string
        {
            return 'youtube';
        }
    }
}

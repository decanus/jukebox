<?php

namespace Jukebox\Framework\ValueObjects\Services
{

    class Youtube implements Service
    {

        public function __toString(): string
        {
            return 'youtube';
        }
    }
}

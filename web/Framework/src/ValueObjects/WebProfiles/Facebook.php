<?php

namespace Jukebox\Framework\ValueObjects\WebProfiles
{
    class Facebook implements WebProfile
    {
        public function __toString(): string
        {
            return 'facebook';
        }
    }
}

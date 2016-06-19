<?php

namespace Jukebox\Framework\ValueObjects\WebProfiles
{
    class Twitter implements WebProfile
    {

        public function __toString(): string
        {
            return 'twitter';
        }
    }
}

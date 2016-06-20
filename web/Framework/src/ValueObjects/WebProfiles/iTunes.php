<?php

namespace Jukebox\Framework\ValueObjects\WebProfiles
{
    class iTunes implements WebProfile
    {

        public function __toString(): string
        {
            return 'itunes';
        }
    }
}

<?php

namespace Jukebox\Framework\ValueObjects\WebProfiles
{
    class Amazon implements WebProfile
    {

        public function __toString(): string
        {
            return 'amazon';
        }
    }
}

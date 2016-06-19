<?php

namespace Jukebox\Framework\ValueObjects\WebProfiles
{
    class OfficialWebsite implements WebProfile
    {

        public function __toString(): string
        {
            return 'official_website';
        }
    }
}

<?php

namespace Jukebox\Backend\ValueObjects\Sitemap\ChangeFrequency
{
    class Weekly implements ChangeFrequency
    {

        public function __toString(): string
        {
            return 'weekly';
        }
    }
}

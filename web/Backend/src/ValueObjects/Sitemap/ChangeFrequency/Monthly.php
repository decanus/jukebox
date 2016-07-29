<?php

namespace Jukebox\Backend\ValueObjects\Sitemap\ChangeFrequency
{
    class Monthly implements ChangeFrequency
    {

        public function __toString(): string
        {
            return 'monthly';
        }
    }
}

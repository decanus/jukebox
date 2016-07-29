<?php

namespace Jukebox\Backend\ValueObjects\Sitemap\ChangeFrequency
{
    class Daily implements ChangeFrequency
    {

        public function __toString(): string
        {
            return 'daily';
        }
    }
}

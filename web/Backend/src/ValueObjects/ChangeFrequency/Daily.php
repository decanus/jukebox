<?php

namespace Jukebox\Backend\ValueObjects\ChangeFrequency
{
    class Daily implements ChangeFrequency
    {

        public function __toString(): string
        {
            return 'daily';
        }
    }
}

<?php

namespace Jukebox\Backend\ValueObjects\ChangeFrequency
{
    class Weekly implements ChangeFrequency
    {

        public function __toString(): string
        {
            return 'weekly';
        }
    }
}

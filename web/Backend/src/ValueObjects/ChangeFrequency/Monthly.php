<?php

namespace Jukebox\Backend\ValueObjects\ChangeFrequency
{
    class Monthly implements ChangeFrequency
    {

        public function __toString(): string
        {
            return 'monthly';
        }
    }
}

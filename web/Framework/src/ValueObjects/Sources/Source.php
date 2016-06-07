<?php

namespace Jukebox\Framework\ValueObjects\Sources
{

    interface Source
    {
        public function __toString(): string;
    }
}

<?php

namespace Jukebox\Framework\ValueObjects\Services
{

    interface Service
    {
        public function __toString(): string;
    }
}

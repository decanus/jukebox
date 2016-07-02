<?php

namespace Jukebox\Framework\ValueObjects
{
    class RefreshToken extends Token
    {
        protected function getLength(): int
        {
            return 120;
        }
    }
}

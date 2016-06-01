<?php

namespace Jukebox\Framework\ValueObjects
{
    class AccessToken extends Token
    {
        protected function getLength(): int
        {
            return 60;
        }
    }
}

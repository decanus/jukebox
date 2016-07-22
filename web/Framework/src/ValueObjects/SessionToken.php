<?php

namespace Jukebox\Framework\ValueObjects
{
    class SessionToken extends Token
    {

        protected function getLength(): int
        {
            return 24;
        }
    }
}

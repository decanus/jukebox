<?php

namespace Jukebox\API\ValueObjects
{
    class Hash
    {
        private $hash;
        
        public function __construct(string $string, Salt $salt)
        {
            $this->hash = hash('sha256', $string . (string) $salt);
        }

        public function __toString(): string
        {
            return $this->hash;
        }
    }
}

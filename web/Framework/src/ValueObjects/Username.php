<?php

namespace Jukebox\Framework\ValueObjects
{
    class Username
    {
        private $username;

        public function __construct(string $username)
        {
            if (!ctype_alnum($username)) {
                throw new \InvalidArgumentException('"' . $username .'" is not a valid username');
            }

            $this->username = $username;
        }

        public function __toString(): string
        {
            return $this->username;
        }
    }
}

<?php

namespace Jukebox\Framework\ValueObjects
{
    class Password
    {
        private $password;

        public function __construct(string $password)
        {
            if (strlen($password) < 6) {
                throw new \InvalidArgumentException('Password must be at least 6 characters');
            }
            $this->password = $password;
        }

        public function __toString(): string
        {
            return $this->password;
        }
    }
}

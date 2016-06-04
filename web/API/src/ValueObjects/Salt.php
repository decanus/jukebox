<?php

namespace Jukebox\API\ValueObjects
{
    class Salt
    {
        private $salt;

        public function __construct(string $salt = '')
        {
            if ($salt === '') {
                $salt = md5(mt_rand());
            }

            $this->salt = $salt;
        }

        public function __toString(): string
        {
            return $this->salt;
        }
    }
}

<?php

namespace Jukebox\Framework\ValueObjects
{
    class PostgresBool
    {
        /**
         * @var string
         */
        private $bool;

        public function __construct(bool $bool)
        {
            if ($bool) {
                $this->bool = 't';
            } else {
                $this->bool = 'f';
            }
        }

        public function __toString()
        {
            return $this->bool;
        }
    }
}

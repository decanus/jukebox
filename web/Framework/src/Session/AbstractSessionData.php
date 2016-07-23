<?php

namespace Jukebox\Framework\Session
{
    abstract class AbstractSessionData
    {
        private $map;

        public function __construct(Map $map)
        {
            $this->map = $map;
        }

        public function isEmpty(): bool
        {
            return $this->map->isEmpty();
        }

        public function getMap(): Map
        {
            return $this->map;
        }
    }
}

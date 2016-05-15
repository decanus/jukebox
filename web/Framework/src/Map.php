<?php

namespace Park\Framework
{
    class Map
    {
        private $data = [];

        public function has(string $key): bool
        {
            return isset($this->data[$key]);
        }

        public function get(string $key): string
        {
            if (!$this->has($key)) {
                throw new \Exception('Key "' . $key . '" not found');
            }

            return $this->data[$key];
        }

        public function set(string $key, string $value)
        {
            if ($this->has($key)) {
                throw new \Exception('Key "' . $key . '" already exists');
            }

            $this->data[$key] = $value;
        }

        public function remove(string $key)
        {
            unset($this->data[$key]);
        }

        public function getIterator(): \ArrayIterator
        {
            return new \ArrayIterator($this->data);
        }
    }
}

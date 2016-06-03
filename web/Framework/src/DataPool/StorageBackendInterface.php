<?php


namespace Jukebox\Framework\DataPool
{
    interface StorageBackendInterface
    {
        public function has(string $key): bool;
        public function get(string $key): string;
        public function set(string $key, string $value);

        public function hhas(string $key, string $hashKey): bool;
        public function hset(string $key, string $hashKey, string $value);
        public function hget(string $key, string $hashKey): string;
        public function hmset(string $key, array $hashKeys);
    }
}

<?php


namespace Jukebox\Framework\Session
{
    interface SessionStoreInterface
    {
        public function loadById(string $id): Map;

        public function save(string $id, Map $data);

        public function remove(string $id): bool;

        public function expire(string $id, int $expireInSeconds): bool;
    }
}

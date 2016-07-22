<?php

namespace Jukebox\Framework\Session
{

    use Jukebox\Framework\DataPool\RedisBackend;

    abstract class AbstractSessionStore implements SessionStoreInterface
    {
        /**
         * @var RedisBackend
         */
        private $redisBackend;

        public function __construct(RedisBackend $redisBackend)
        {
            $this->redisBackend = $redisBackend;
        }

        public function loadById(string $id): Map
        {
            try {
                $map = $this->redisBackend->get($this->generateSessionKey($id));
            } catch (\Exception $e) {
                return new Map;
            }

            return unserialize($map);
        }

        public function save(string $id, Map $data)
        {
            $this->redisBackend->set($this->generateSessionKey($id), serialize($data));
        }

        public function remove(string $id): bool
        {
            return $this->redisBackend->remove($this->generateSessionKey($id));
        }

        public function expire(string $id, int $expireInSeconds): bool
        {
            return $this->redisBackend->expire($this->generateSessionKey($id), $expireInSeconds);
        }

        abstract protected function generateSessionKey($id): string;
    }
}

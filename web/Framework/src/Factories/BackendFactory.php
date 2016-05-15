<?php

namespace Jukebox\Framework\Factories
{
    class BackendFactory extends AbstractFactory
    {
        public function createFileBackend(): \Jukebox\Framework\Backends\FileBackend
        {
            return new \Jukebox\Framework\Backends\FileBackend;
        }

        public function createRedisBackend(): \Jukebox\Framework\DataPool\RedisBackend
        {
            return new \Jukebox\Framework\DataPool\RedisBackend(
                new \Redis,
                $this->getMasterFactory()->getConfiguration()->get('redisHost'),
                $this->getMasterFactory()->getConfiguration()->get('redisPort')
            );
        }
    }
}

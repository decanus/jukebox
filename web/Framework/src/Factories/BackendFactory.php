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

        public function createMongoDatabaseBackend(): \Jukebox\Framework\Backends\MongoDatabaseBackend
        {
            return new \Jukebox\Framework\Backends\MongoDatabaseBackend(
                new \MongoDB\Client($this->getMasterFactory()->getConfiguration()->get('mongoServer')),
                $this->getMasterFactory()->getConfiguration()->get('mongoDatabase')
            );
        }
    }
}

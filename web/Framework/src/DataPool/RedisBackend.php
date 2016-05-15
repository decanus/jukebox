<?php

namespace Jukebox\Framework\DataPool
{

    use Jukebox\Framework\Events\EventInterface;

    class RedisBackend
    {
        /**
         * @var \Redis
         */
        private $redis;

        /**
         * @var string
         */
        private $host;

        /**
         * @var int
         */
        private $port;

        /**
         * @var bool
         */
        private $isConnected = false;

        public function __construct(\Redis $redis, string $host, int $port)
        {
            $this->redis = $redis;
            $this->host = $host;
            $this->port = $port;
        }

        public function set(string $key, string $value)
        {
            $this->connect();
            $result = $this->redis->set($key, $value);

            if ($result === false) {
                throw new \Exception('Failed to write key "' . $key . '" to Redis');
            }
        }

        public function has(string $key): bool
        {
            $this->connect();
            return $this->redis->get($key) !== false;
        }

        public function get(string $key): string
        {
            $this->connect();
            $result = $this->redis->get($key);

            if ($result === false) {
                throw new \Exception('Failed to read key "' . $key . '" from Redis');
            }

            return $result;
        }

        public function remove(string $key): int
        {
            $this->connect();
            return $this->redis->del($key);
        }

        public function fetchFromQueue(string $queueName): EventInterface
        {
            $this->connect();
            return unserialize($this->redis->blPop($queueName, 0)[1]);
        }

        public function addToQueue(string $queueName, EventInterface $event): int
        {
            $this->connect();
            return $this->redis->rPush($queueName, serialize($event));
        }

        public function prependToQueue(string $queueName, EventInterface $event): int
        {
            $this->connect();
            return $this->redis->lPush($queueName, serialize($event));
        }

        public function getQueueLength(string $queueName): int
        {
            $this->connect();
            return $this->redis->lLen($queueName);
        }

        public function emptyQueue(string $queueName)
        {
            $this->connect();
            $this->redis->delete($queueName);
        }

        private function connect()
        {
            if ($this->isConnected) {
                return;
            }

            $this->redis->connect($this->host, $this->port);
        }
    }
}

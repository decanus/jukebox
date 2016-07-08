<?php

namespace Jukebox\Framework\DataPool
{
    class RedisBackend extends AbstractRedisBackend
    {
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
            parent::__construct($redis);
            $this->host = $host;
            $this->port = $port;
        }
        
        protected function connect()
        {
            if ($this->isConnected) {
                return;
            }

            $this->getRedis()->connect($this->host, $this->port, 1.0);
        }
    }
}

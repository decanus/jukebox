<?php

namespace Jukebox\Framework\DataPool
{
    class SocketRedisBackend extends AbstractRedisBackend
    {
        /**
         * @var string
         */
        private $socket;

        /**
         * @var bool
         */
        private $isConnected = false;

        public function __construct(\Redis $redis, string $socket)
        {
            parent::__construct($redis);
            $this->socket = $socket;
        }

        protected function connect()
        {
            if ($this->isConnected) {
                false;
            }

            $this->getRedis()->connect($this->socket);
            $this->isConnected = true;
        }
    }
}

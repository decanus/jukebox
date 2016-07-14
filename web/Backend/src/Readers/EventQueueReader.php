<?php

namespace Jukebox\Backend\Readers
{

    use Jukebox\Framework\DataPool\RedisBackend;
    use Jukebox\Framework\Events\EventInterface;

    class EventQueueReader
    {
        /**
         * @var string
         */
        private $queueName = 'eventQueue';

        /**
         * @var RedisBackend
         */
        private $redisBackend;

        public function __construct(RedisBackend $redisBackend)
        {
            $this->redisBackend = $redisBackend;
        }

        public function count(): int
        {
            return $this->redisBackend->getQueueLength($this->queueName);
        }

        public function getEvent(): EventInterface
        {
            return $this->redisBackend->fetchFromQueue($this->queueName);
        }
    }
}

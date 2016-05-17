<?php

namespace Jukebox\Backend\Writers
{

    use Jukebox\Framework\DataPool\RedisBackend;
    use Jukebox\Framework\Events\EventInterface;

    class EventQueueWriter
    {
        /**
         * @var RedisBackend
         */
        private $redisBackend;

        /**
         * @param RedisBackend $redisBackend
         */
        public function __construct(RedisBackend $redisBackend)
        {
            $this->redisBackend = $redisBackend;
        }

        public function add(EventInterface $event)
        {
            $this->redisBackend->addToQueue('eventQueue', $event);
        }
    }
}

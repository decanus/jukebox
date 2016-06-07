<?php

namespace Jukebox\Backend\Writers
{

    use Jukebox\Framework\DataPool\RedisBackend;
    use Jukebox\Framework\Events\EventInterface;
    use Jukebox\Framework\ValueObjects\DataVersion;

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

        public function count()
        {
            return $this->redisBackend->getQueueLength('eventQueue');
        }

        // @todo does not belong here
        public function getDataVersion(): DataVersion
        {
            return new DataVersion($this->redisBackend->get('currentDataVersion'));
        }
    }
}

<?php

namespace Jukebox\Backend\EventHandlers
{

    use Jukebox\Backend\Events\OldDataVersionDeleteEvent;
    use Jukebox\Framework\DataPool\RedisBackend;

    class OldDataVersionDeleteEventHandler implements EventHandlerInterface
    {
        /**
         * @var OldDataVersionDeleteEvent
         */
        private $event;

        /**
         * @var RedisBackend
         */
        private $redisBackend;

        public function __construct(OldDataVersionDeleteEvent $event, RedisBackend $redisBackend)
        {
            $this->redisBackend = $redisBackend;
            $this->event = $event;
        }

        public function execute()
        {
            $this->redisBackend->remove((string) $this->event->getDataVersion());
        }
    }
}

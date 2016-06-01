<?php

namespace Jukebox\Backend\EventHandlers\Push
{

    use Jukebox\Backend\EventHandlers\EventHandlerInterface;
    use Jukebox\Backend\Events\DataVersionPushEvent;
    use Jukebox\Framework\DataPool\RedisBackend;

    class DataVersionPushEventHandler implements EventHandlerInterface
    {

        /**
         * @var DataVersionPushEvent
         */
        private $event;

        /**
         * @var RedisBackend
         */
        private $redisBackend;

        public function __construct(DataVersionPushEvent $event, RedisBackend $redisBackend)
        {
            $this->event = $event;
            $this->redisBackend = $redisBackend;
        }

        public function execute()
        {
            $this->redisBackend->set('currentDataVersion', (string) $this->event->getDataVersion());
        }
    }
}

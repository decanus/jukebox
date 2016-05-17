<?php

namespace Jukebox\Backend\Factories
{

    use Jukebox\Framework\Factories\AbstractFactory;

    class ReaderFactory extends AbstractFactory
    {
        public function createEventQueueReader(): \Jukebox\Backend\Readers\EventQueueReader
        {
            return new \Jukebox\Backend\Readers\EventQueueReader($this->getMasterFactory()->createRedisBackend());
        }
    }
}

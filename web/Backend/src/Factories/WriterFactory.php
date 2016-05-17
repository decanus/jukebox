<?php

namespace Jukebox\Backend\Factories
{

    use Jukebox\Framework\Factories\AbstractFactory;

    class WriterFactory extends AbstractFactory
    {
        public function createEventQueueWriter(): \Jukebox\Backend\Writers\EventQueueWriter
        {
            return new \Jukebox\Backend\Writers\EventQueueWriter(
                $this->getMasterFactory()->createRedisBackend()
            );
        }
    }
}

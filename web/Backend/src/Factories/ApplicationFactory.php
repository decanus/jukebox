<?php

namespace Jukebox\Backend\Factories
{
    class ApplicationFactory extends \Jukebox\Framework\Factories\ApplicationFactory
    {
        public function createWorker(): \Jukebox\Backend\Worker
        {
            return new \Jukebox\Backend\Worker(
                $this->getMasterFactory()->createEventQueueReader(),
                $this->getMasterFactory()->createEventHandlerLocator()
            );
        }
    }
}

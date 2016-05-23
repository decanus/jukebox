<?php

namespace Jukebox\Backend
{

    use Jukebox\Backend\Locators\EventHandlerLocator;
    use Jukebox\Backend\Readers\EventQueueReader;

    class Worker
    {
        /**
         * @var EventQueueReader
         */
        private $eventQueueReader;

        /**
         * @var EventHandlerLocator
         */
        private $eventHandlerLocator;

        /**
         * @param EventQueueReader $eventQueueReader
         * @param EventHandlerLocator $eventHandlerLocator
         */
        public function __construct(EventQueueReader $eventQueueReader, EventHandlerLocator $eventHandlerLocator)
        {
            $this->eventQueueReader = $eventQueueReader;
            $this->eventHandlerLocator = $eventHandlerLocator;
        }

        public function process($maxNumberOfEvents = 1000)
        {
            $loopCount = 0;
            /**
             * sleep 1s bevor es los geht, damit supervisord den worker als "alive" erkennt
             */
            sleep(1);

            while (true) {
                try {

                    if ($loopCount >= $maxNumberOfEvents) {
                        return;
                    }

                    if ($this->eventQueueReader->count() === 0) {
                        sleep(rand(5, 15));
                        continue;
                    }

                    $event = $this->eventQueueReader->getEvent();

                    $handler = $this->eventHandlerLocator->locate($event);
                    
                    $handler->execute();

                } catch (\Throwable $e) {
                    exit(1);
                }
            }
        }
    }
}

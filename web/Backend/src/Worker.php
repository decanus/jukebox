<?php

namespace Jukebox\Backend
{

    use Jukebox\Backend\Locators\EventHandlerLocator;
    use Jukebox\Backend\Readers\EventQueueReader;
    use Jukebox\Framework\Logging\LoggerAware;
    use Jukebox\Framework\Logging\LoggerAwareTrait;

    class Worker implements LoggerAware
    {
        /**
         * @trait
         */
        use LoggerAwareTrait;

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
                        $this->sleep();
                        continue;
                    }

                    $event = $this->eventQueueReader->getEvent();

                    $handler = $this->eventHandlerLocator->locate($event);
                    
                    $handler->execute();
                    gc_collect_cycles();

                    $loopCount++;
                } catch (\Throwable $e) {
                    $this->getLogger()->emergency($e);
                    $this->shutdown();
                }
            }
        }

        private function sleep()
        {
            if (memory_get_usage(true) > 314572800) {
                $this->shutdown();
            }

            sleep(rand(5, 15));
        }

        private function shutdown()
        {
            exit(1);
        }
    }
}

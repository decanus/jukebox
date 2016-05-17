<?php

namespace Jukebox\Backend\Locators
{

    use Jukebox\Framework\Events\EventInterface;

    class EventLocator
    {
        public function locate(string $event): EventInterface
        {
            switch ($event) {
                default:
                    throw new \InvalidArgumentException('Event "' . $event . '" does not exist');
            }
        }
    }
}

<?php

namespace Jukebox\Backend\Factories
{

    use Jukebox\Framework\Factories\AbstractFactory;

    class LocatorFactory extends AbstractFactory
    {
        public function createEventHandlerLocator(): \Jukebox\Backend\Locators\EventHandlerLocator
        {
            return new \Jukebox\Backend\Locators\EventHandlerLocator($this->getMasterFactory());
        }

        public function createEventLocator(): \Jukebox\Backend\Locators\EventLocator
        {
            return new \Jukebox\Backend\Locators\EventLocator($this->getMasterFactory());
        }
    }
}

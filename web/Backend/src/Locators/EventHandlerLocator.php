<?php

namespace Jukebox\Backend\Locators
{

    use Jukebox\Backend\EventHandlers\EventHandlerInterface;
    use Jukebox\Backend\Factories\EventHandlerFactory;
    use Jukebox\Framework\Events\EventInterface;
    use Jukebox\Framework\Factories\MasterFactory;

    class EventHandlerLocator
    {
        /**
         * @var EventHandlerFactory
         */
        private $factory;

        /**
         * @param MasterFactory $factory
         */
        public function __construct(MasterFactory $factory)
        {
            $this->factory = $factory;
        }

        public function locate(EventInterface $event): EventHandlerInterface
        {
            switch ($event->getName()) {
                case 'InitialVevoArtistsImport':
                    return $this->factory->createInitialVevoArtistsImportEventHandler();
                case 'VevoGenresImport':
                    return $this->factory->createVevoGenresImportEventHandler();
            }
        }
    }
}

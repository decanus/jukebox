<?php

namespace Jukebox\Backend\Factories
{

    use Jukebox\Framework\Factories\AbstractFactory;

    class EventHandlerFactory extends AbstractFactory
    {
        public function createInitialVevoArtistsImportEventHandler(): \Jukebox\Backend\EventHandlers\Import\InitialVevoArtistsImportEventHandler
        {
            return new \Jukebox\Backend\EventHandlers\Import\InitialVevoArtistsImportEventHandler(
                $this->getMasterFactory()->createVevoService()
            );
        }
        
        public function createInitialVevoGenresImportEventHandler(): \Jukebox\Backend\EventHandlers\Import\InitialVevoGenresImportEventHandler
        {
            return new \Jukebox\Backend\EventHandlers\Import\InitialVevoGenresImportEventHandler(
                $this->getMasterFactory()->createVevoService()
            );
        }

        public function createVevoArtistImportEventHandler(\Jukebox\Backend\Events\VevoArtistImportEvent $event): \Jukebox\Backend\EventHandlers\Import\VevoArtistImportEventHandler
        {
            return new \Jukebox\Backend\EventHandlers\Import\VevoArtistImportEventHandler(
                $event,
                $this->getMasterFactory()->createVevoService()
            );
        }
    }
}

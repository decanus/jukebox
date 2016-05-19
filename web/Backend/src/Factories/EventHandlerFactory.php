<?php

namespace Jukebox\Backend\Factories
{

    use Jukebox\Framework\Factories\AbstractFactory;

    class EventHandlerFactory extends AbstractFactory
    {
        public function createInitialVevoArtistsImportEventHandler(): \Jukebox\Backend\EventHandlers\Import\InitialVevoArtistsImportEventHandler
        {
            return new \Jukebox\Backend\EventHandlers\Import\InitialVevoArtistsImportEventHandler(
                $this->getMasterFactory()->createVevoService(),
                $this->getMasterFactory()->createEventQueueWriter()
            );
        }
        
        public function createVevoGenresImportEventHandler(): \Jukebox\Backend\EventHandlers\Import\VevoGenresImportEventHandler
        {
            return new \Jukebox\Backend\EventHandlers\Import\VevoGenresImportEventHandler(
                $this->getMasterFactory()->createVevoService(),
                $this->getMasterFactory()->createInsertGenreCommand()
            );
        }

        public function createVevoArtistImportEventHandler(\Jukebox\Backend\Events\VevoArtistImportEvent $event): \Jukebox\Backend\EventHandlers\Import\VevoArtistImportEventHandler
        {
            return new \Jukebox\Backend\EventHandlers\Import\VevoArtistImportEventHandler(
                $event,
                $this->getMasterFactory()->createVevoService(),
                $this->getMasterFactory()->createInsertVevoArtistCommand()
            );
        }

        public function createVevoArtistVideosImportEventHandler(\Jukebox\Backend\Events\VevoArtistVideosImportEvent $event): \Jukebox\Backend\EventHandlers\Import\VevoArtistVideosImportEventHandler
        {
            return new \Jukebox\Backend\EventHandlers\Import\VevoArtistVideosImportEventHandler(
                $event,
                $this->getMasterFactory()->createVevoService()
            );
        }
    }
}

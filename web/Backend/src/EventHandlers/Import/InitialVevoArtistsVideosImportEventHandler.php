<?php

namespace Jukebox\Backend\EventHandlers\Import
{

    use Jukebox\Backend\EventHandlers\EventHandlerInterface;
    use Jukebox\Framework\Logging\LoggerAware;
    use Jukebox\Framework\Logging\LoggerTrait;

    class InitialVevoArtistsVideosImportEventHandler implements EventHandlerInterface, LoggerAware
    {
        /**
         * @trait
         */
        use LoggerTrait;

        public function execute()
        {
            // TODO: Get all vevo artists from db and trigger VevoArtistVideoImport
        }
    }
}

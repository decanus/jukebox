<?php

namespace Jukebox\Backend\EventHandlers\Import
{

    use Jukebox\Backend\EventHandlers\EventHandlerInterface;
    use Jukebox\Framework\Logging\LoggerAware;
    use Jukebox\Framework\Logging\LoggingProvider;

    class InitialVevoArtistsVideosImportEventHandler implements EventHandlerInterface, LoggerAware
    {
        /**
         * @trait
         */
        use LoggingProvider;

        public function execute()
        {
            // TODO: Implement execute() method.
        }
    }
}

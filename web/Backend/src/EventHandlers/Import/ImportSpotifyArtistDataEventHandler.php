<?php

namespace Jukebox\Backend\EventHandlers\Import
{

    use Jukebox\Backend\EventHandlers\EventHandlerInterface;
    use Jukebox\Backend\Events\ImportSpotifyArtistDataEvent;

    class ImportSpotifyArtistDataEventHandler implements EventHandlerInterface
    {
        /**
         * @var ImportSpotifyArtistDataEvent
         */
        private $event;

        public function __construct(ImportSpotifyArtistDataEvent $event)
        {
            $this->event = $event;
        }

        public function execute()
        {
            // TODO: Implement execute() method.
        }
    }

}

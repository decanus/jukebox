<?php

namespace Jukebox\Backend\EventHandlers\Import
{

    use Jukebox\Backend\EventHandlers\EventHandlerInterface;
    use Jukebox\Backend\Events\ImportSpotifyArtistDataEvent;
    use Jukebox\Backend\Services\Spotify;

    class ImportSpotifyArtistDataEventHandler implements EventHandlerInterface
    {
        /**
         * @var ImportSpotifyArtistDataEvent
         */
        private $event;
        /**
         * @var Spotify
         */
        private $spotify;

        public function __construct(
            ImportSpotifyArtistDataEvent $event,
            Spotify $spotify
        )
        {
            $this->event = $event;
            $this->spotify = $spotify;
        }

        public function execute()
        {
            try {
                $response = $this->spotify->getArtist($this->event->getArtistId());
            } catch (\Exception $e) {
                // @todo handle
            }
        }
    }

}

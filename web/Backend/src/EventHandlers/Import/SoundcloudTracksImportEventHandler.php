<?php

namespace Jukebox\Backend\EventHandlers\Import
{

    use Jukebox\API\Queries\FetchTracksForArtistQuery;
    use Jukebox\Backend\EventHandlers\EventHandlerInterface;
    use Jukebox\Backend\Events\SoundcloudTracksImportEvent;
    use Jukebox\Backend\Queries\FetchArtistByIdQuery;
    use Jukebox\Backend\Services\Soundcloud;
    use Jukebox\Framework\Logging\LoggerAware;
    use Jukebox\Framework\Logging\LoggerAwareTrait;
    use Jukebox\Framework\Rest\JukeboxRestManager;

    class SoundcloudTracksImportEventHandler implements EventHandlerInterface, LoggerAware
    {
        use LoggerAwareTrait;

        /**
         * @var SoundcloudTracksImportEvent
         */
        private $event;

        /**
         * @var FetchArtistByIdQuery
         */
        private $fetchArtistByIdQuery;

        /**
         * @var Soundcloud
         */
        private $soundcloud;
        
        /**
         * @var JukeboxRestManager
         */
        private $jukeboxRestManager;

        public function __construct(
            SoundcloudTracksImportEvent $event,
            FetchArtistByIdQuery $fetchArtistByIdQuery,
            Soundcloud $soundcloud,
            JukeboxRestManager $jukeboxRestManager
        )
        {
            $this->event = $event;
            $this->fetchArtistByIdQuery = $fetchArtistByIdQuery;
            $this->soundcloud = $soundcloud;
            $this->jukeboxRestManager = $jukeboxRestManager;
        }

        public function execute()
        {
            try {

                $artist = $this->fetchArtistByIdQuery->execute($this->event->getArtistId());
                $response = $this->soundcloud->getArtistTracks($artist['soundcloud_id']);

                if ($response->getResponseCode() !== 200) {
                    throw new \RuntimeException('Failed to load data for "' . $artist['name'] . '"');
                }

                $tracks = $response->getDecodedJsonResponse();
                $artistTracks = $this->jukeboxRestManager->getTracksByArtistId($artist['id'])->getDecodedJsonResponse();

                foreach ($tracks as $track) {

                    

                }
                
            } catch (\Throwable $e) {
                $this->getLogger()->critical($e);
            }
        }
    }
}

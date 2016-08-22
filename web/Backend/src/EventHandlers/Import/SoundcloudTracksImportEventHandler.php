<?php

namespace Jukebox\Backend\EventHandlers\Import
{

    use Jukebox\Backend\Commands\InsertTrackCommand;
    use Jukebox\Backend\DataObjects\Track;
    use Jukebox\Backend\EventHandlers\EventHandlerInterface;
    use Jukebox\Backend\Events\SoundcloudTracksImportEvent;
    use Jukebox\Backend\Queries\FetchArtistByIdQuery;
    use Jukebox\Backend\Queries\FetchArtistBySoundcloudIdQuery;
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
         * @var Soundcloud
         */
        private $soundcloud;
        
        /**
         * @var JukeboxRestManager
         */
        private $jukeboxRestManager;

        /**
         * @var FetchArtistBySoundcloudIdQuery
         */
        private $fetchArtistBySoundcloudIdQuery;

        /**
         * @var InsertTrackCommand
         */
        private $insertTrackCommand;

        public function __construct(
            SoundcloudTracksImportEvent $event,
            Soundcloud $soundcloud,
            JukeboxRestManager $jukeboxRestManager,
            FetchArtistBySoundcloudIdQuery $fetchArtistBySoundcloudIdQuery,
            InsertTrackCommand $insertTrackCommand
        )
        {
            $this->event = $event;
            $this->soundcloud = $soundcloud;
            $this->jukeboxRestManager = $jukeboxRestManager;
            $this->fetchArtistBySoundcloudIdQuery = $fetchArtistBySoundcloudIdQuery;
            $this->insertTrackCommand = $insertTrackCommand;
        }

        public function execute()
        {
            try {
                $response = $this->soundcloud->getArtistTracks($this->event->getSoundcloudId());
                $artist = $this->fetchArtistBySoundcloudIdQuery->execute($this->event->getSoundcloudId());

                if ($response->getResponseCode() !== 200) {
                    throw new \RuntimeException('Failed to load data for "' . $this->event->getSoundcloudId() . '"');
                }

                $tracks = $response->getDecodedJsonResponse();

                foreach ($tracks as $track) {

                    $isrc = null;
                    if ($track['isrc'] !== '' && $track['isrc'] !== null) {
                        $isrc = $track['isrc'];
                    }

                    $permalink = $artist['permalink'] . '/' . $track['permalink'];

                    $obj = new Track(
                        $track['duration'],
                        $track['title'],
                        null,
                        $isrc,
                        false,
                        false,
                        true,
                        false,
                        false,
                        $permalink,
                        new \DateTime($track['created_at'])
                    );

                    $this->insertTrackCommand->execute($obj);
                }
                
            } catch (\Throwable $e) {
                $this->getLogger()->critical($e);
            }
        }
    }
}

<?php

namespace Jukebox\Backend\EventHandlers\Import
{

    use Jukebox\Backend\DataObjects\Track;
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
         * @var Soundcloud
         */
        private $soundcloud;
        
        /**
         * @var JukeboxRestManager
         */
        private $jukeboxRestManager;

        public function __construct(
            SoundcloudTracksImportEvent $event,
            Soundcloud $soundcloud,
            JukeboxRestManager $jukeboxRestManager
        )
        {
            $this->event = $event;
            $this->soundcloud = $soundcloud;
            $this->jukeboxRestManager = $jukeboxRestManager;
        }

        public function execute()
        {
            try {
                $response = $this->soundcloud->getArtistTracks($this->event->getSoundcloudId());

                if ($response->getResponseCode() !== 200) {
                    throw new \RuntimeException('Failed to load data for "' . $this->event->getSoundcloudId() . '"');
                }

                $tracks = $response->getDecodedJsonResponse();

                foreach ($tracks as $track) {

                    $isrc = null;
                    if ($track['isrc'] !== '' && $track['isrc'] !== null) {
                        $isrc = $track['isrc'];
                    }

                    $permalink = '';

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

                    // @todo insert new track
                }
                
            } catch (\Throwable $e) {
                $this->getLogger()->critical($e);
            }
        }
    }
}

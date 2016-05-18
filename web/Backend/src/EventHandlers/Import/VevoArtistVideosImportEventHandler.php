<?php

namespace Jukebox\Backend\EventHandlers\Import
{

    use Jukebox\Backend\EventHandlers\EventHandlerInterface;
    use Jukebox\Backend\Events\VevoArtistVideosImportEvent;
    use Jukebox\Backend\Services\Vevo;
    use Jukebox\Framework\Logging\LoggerAware;
    use Jukebox\Framework\Logging\LoggingProvider;

    class VevoArtistVideosImportEventHandler implements EventHandlerInterface, LoggerAware
    {
        /**
         * @trait
         */
        use LoggingProvider;

        /**
         * @var VevoArtistVideosImportEvent
         */
        private $event;

        /**
         * @var Vevo
         */
        private $vevo;

        private $videoIds = [];

        public function __construct(VevoArtistVideosImportEvent $event, Vevo $vevo)
        {
            $this->event = $event;
            $this->vevo = $vevo;
        }

        public function execute()
        {
            try {

                $artist = $this->event->getArtist();
                $response = $this->vevo->getVideosForArtist($artist);
                $videos = $response->getDecodedJsonResponse();
                $this->handleVideos($videos);

                if ($videos['paging']['pages'] === 1) {
                    return;
                }

                $pages = $videos['paging']['pages'];
                for ($i = 2; $i <= $pages; $i++) {
                    $response = $this->vevo->getVideosForArtist($artist, $i);
                    $videos = $response->getDecodedJsonResponse();
                    $this->handleVideos($videos);
                }

                // @todo: should probably change MultiCurl to rollingCurl so we don't fill ram with 80+ videos
                $videos = $this->vevo->getVideosForIds($this->videoIds);

                foreach ($videos as $video) {
                    // @todo: put into DB etc
                }

            } catch (\Throwable $e) {
                $this->logCritical($e);
            }
        }

        private function handleVideos(array $videos)
        {
            foreach ($videos as $video) {
                $this->videoIds[] = $video['isrc'];
            }
        }
    }
}

<?php

namespace Jukebox\Backend\EventHandlers\Import
{

    use Jukebox\Backend\EventHandlers\EventHandlerInterface;
    use Jukebox\Backend\Events\VevoArtistVideosImportEvent;
    use Jukebox\Backend\Services\Vevo;
    use Jukebox\Framework\Curl\Response;
    use Jukebox\Framework\Logging\LoggerAware;
    use Jukebox\Framework\Logging\LoggerTrait;

    class VevoArtistVideosImportEventHandler implements EventHandlerInterface, LoggerAware
    {
        /**
         * @trait
         */
        use LoggerTrait;

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
                $this->handleVideoIds($videos['videos']);

                if ($videos['paging']['pages'] > 1) {
                    $pages = $videos['paging']['pages'];
                    for ($i = 2; $i <= $pages; $i++) {
                        $response = $this->vevo->getVideosForArtist($artist, $i);
                        $videos = $response->getDecodedJsonResponse();
                        $this->handleVideoIds($videos['videos']);
                    }
                }

                $this->vevo->getVideosForIds($this->videoIds, [$this, 'handleVideos']);

            } catch (\Throwable $e) {
                $this->critical($e);
            }
        }

        public function handleVideos(string $id, Response $response)
        {
            try {
                if ($response->getResponseCode() !== 200) {
                    return;
                }

                $video = $response->getDecodedJsonResponse();

                $video['title'];

            } catch (\Throwable $e) {
                return;
            }

        }

        private function handleVideoIds(array $videos)
        {
            foreach ($videos as $video) {
                $this->videoIds[] = $video['isrc'];
            }
        }
    }
}

<?php

namespace Jukebox\Backend\EventHandlers\Import
{

    use Jukebox\Backend\Commands\InsertTrackArtistCommand;
    use Jukebox\Backend\Commands\InsertTrackCommand;
    use Jukebox\Backend\EventHandlers\EventHandlerInterface;
    use Jukebox\Backend\Events\VevoArtistVideosImportEvent;
    use Jukebox\Backend\Queries\FetchArtistByVevoIdQuery;
    use Jukebox\Backend\Services\Vevo;
    use Jukebox\Framework\Curl\Response;
    use Jukebox\Framework\Logging\LoggerAware;
    use Jukebox\Framework\Logging\LoggerAwareTrait;
    use Jukebox\Framework\ValueObjects\Featured;
    use Jukebox\Framework\ValueObjects\Main;

    class VevoArtistVideosImportEventHandler implements EventHandlerInterface, LoggerAware
    {
        /**
         * @trait
         */
        use LoggerAwareTrait;

        /**
         * @var VevoArtistVideosImportEvent
         */
        private $event;

        /**
         * @var Vevo
         */
        private $vevo;

        /**
         * @var FetchArtistByVevoIdQuery
         */
        private $fetchArtistByVevoIdQuery;

        /**
         * @var InsertTrackCommand
         */
        private $insertTrackCommand;

        /**
         * @var InsertTrackArtistCommand
         */
        private $insertTrackArtistsCommand;

        private $videoIds = [];

        public function __construct(
            VevoArtistVideosImportEvent $event,
            Vevo $vevo,
            FetchArtistByVevoIdQuery $fetchArtistByVevoIdQuery,
            InsertTrackCommand $insertTrackCommand,
            InsertTrackArtistCommand $insertTrackArtistsCommand
        )
        {
            $this->event = $event;
            $this->vevo = $vevo;
            $this->fetchArtistByVevoIdQuery = $fetchArtistByVevoIdQuery;
            $this->insertTrackCommand = $insertTrackCommand;
            $this->insertTrackArtistsCommand = $insertTrackArtistsCommand;
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
                $this->getLogger()->critical($e);
            }
        }

        public function handleVideos(string $id, Response $response)
        {
            try {
                if ($response->getResponseCode() !== 200) {
                    return;
                }

                $video = $response->getDecodedJsonResponse();

                try {
                    $id = $this->insertTrackCommand->execute(
                        $video['duration'] * 1000,
                        $video['title'],
                        $video['youTubeId'],
                        $video['isrc'],
                        $video['isLive']
                    );
                } catch (\Throwable $e) {
                    return;
                }

                foreach ($video['artists'] as $artist) {
                    try {
                        switch ($artist['role']) {
                            case 'Main':
                                $role = new Main;
                                break;
                            case 'Featured':
                                $role = new Featured;
                                break;
                            default:
                                throw new \InvalidArgumentException('Unknown role "' . $artist['role'] . '"');
                        }
                    } catch (\Throwable $e) {
                        $this->getLogger()->emergency($e);
                        continue;
                    }

                    $artistInfo = $this->fetchArtistByVevoIdQuery->execute($artist['urlSafeName']);
                }

            } catch (\Throwable $e) {
                $this->getLogger()->critical($e);
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

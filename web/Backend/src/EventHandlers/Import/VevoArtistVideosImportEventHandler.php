<?php

namespace Jukebox\Backend\EventHandlers\Import
{

    use Jukebox\Backend\Commands\InsertTrackArtistCommand;
    use Jukebox\Backend\Commands\InsertTrackCommand;
    use Jukebox\Backend\Commands\InsertTrackGenreCommand;
    use Jukebox\Backend\Commands\InsertTrackSourceCommand;
    use Jukebox\Backend\DataObjects\Track;
    use Jukebox\Backend\EventHandlers\EventHandlerInterface;
    use Jukebox\Backend\Events\VevoArtistVideosImportEvent;
    use Jukebox\Backend\Queries\FetchArtistByVevoIdBackendQuery;
    use Jukebox\Backend\Queries\FetchTrackByVevoIdQuery;
    use Jukebox\Backend\Services\Vevo;
    use Jukebox\Framework\Curl\Response;
    use Jukebox\Framework\Logging\LoggerAware;
    use Jukebox\Framework\Logging\LoggerAwareTrait;
    use Jukebox\Framework\ValueObjects\Featured;
    use Jukebox\Framework\ValueObjects\Main;
    use Jukebox\Framework\ValueObjects\Sources\Youtube;

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
         * @var FetchArtistByVevoIdBackendQuery
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

        /**
         * @var InsertTrackGenreCommand
         */
        private $insertTrackGenreCommand;

        /**
         * @var FetchTrackByVevoIdQuery
         */
        private $fetchTrackByVevoIdQuery;

        private $videoIds = [];

        /**
         * @var InsertTrackSourceCommand
         */
        private $insertTrackSourceCommand;

        /**
         * @var InsertTrackCommand
         */
        private $insertTrackCommandv2;

        public function __construct(
            VevoArtistVideosImportEvent $event,
            Vevo $vevo,
            FetchArtistByVevoIdBackendQuery $fetchArtistByVevoIdQuery,
            InsertTrackCommand $insertTrackCommand,
            InsertTrackArtistCommand $insertTrackArtistsCommand,
            InsertTrackGenreCommand $insertTrackGenreCommand,
            FetchTrackByVevoIdQuery $fetchTrackByVevoIdQuery,
            InsertTrackSourceCommand $insertTrackSourceCommand,
            InsertTrackCommand $insertTrackCommandv2
        )
        {
            $this->event = $event;
            $this->vevo = $vevo;
            $this->fetchArtistByVevoIdQuery = $fetchArtistByVevoIdQuery;
            $this->insertTrackCommand = $insertTrackCommand;
            $this->insertTrackArtistsCommand = $insertTrackArtistsCommand;
            $this->insertTrackGenreCommand = $insertTrackGenreCommand;
            $this->fetchTrackByVevoIdQuery = $fetchTrackByVevoIdQuery;
            $this->insertTrackSourceCommand = $insertTrackSourceCommand;
            $this->insertTrackCommandv2 = $insertTrackCommandv2;
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

        public function handleVideos(string $vevoId, Response $response)
        {
            if ($response->getResponseCode() !== 200) {
                return;
            }

            try {
                $video = $response->getDecodedJsonResponse();

                if (isset($video['categories']) && in_array('Shows and Interviews', $video['categories'])) {
                    return;
                }

                if (is_array($this->fetchTrackByVevoIdQuery->execute($video['isrc']))) {
                    return;
                }

                if (!isset($video['youTubeId'])) {
                    return;
                }

                $permalink = '';
                foreach ($video['artists'] as $artist) {
                    if ($artist['role'] === 'Main') {
                        $permalink = preg_replace('/[^A-Za-z0-9 \- \/ ]/', '', strtolower('/' . $artist['urlSafeName'] . '/' . $video['urlSafeTitle']));
                        $permalink = str_replace(' ', '', $permalink);
                        break;
                    }
                }

                $isAudio = false;
                if (strpos($video['title'], '(Audio)') !== false) {
                    $isAudio = true;
                }

                if (strpos($video['title'], '[Audio]') !== false) {
                    $isAudio = true;
                }

                $track = new Track(
                    $video['duration'] * 1000,
                    $video['title'],
                    $video['isrc'],
                    $video['isrc'],
                    $video['isLive'],
                    $video['hasLyrics'],
                    $isAudio,
                    $video['isOfficial'],
                    $video['isExplicit'],
                    $permalink,
                    new \DateTime($video['releaseDate'])
                );

                $artists = [];
                foreach ($video['artists'] as $artist) {
                    try {
                        $artists[] = $this->handleArtist($artist);
                    } catch (\Throwable $e) {
                        $this->getLogger()->critical($e);
                    }
                }

                $sources = [
                    ['duration' => $track->getDuration(), 'source' => new Youtube, 'sourceData' => $video['youTubeId']]
                ];

                $this->insertTrackCommandv2->execute($track, $sources, $video['genres'], $artists);

            } catch (\Throwable $e) {
                $this->getLogger()->critical($e);
            }
        }

        private function handleArtist(array $artist): array
        {
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

            return ['role' => $role, 'vevo_id' => $artist['urlSafeName']];
        }

        private function handleVideoIds(array $videos)
        {
            foreach ($videos as $video) {
                if (isset($video['categories']) && in_array('Shows and Interviews', $video['categories'])) {
                    continue;
                }

                $this->videoIds[] = $video['isrc'];
            }
        }
    }
}

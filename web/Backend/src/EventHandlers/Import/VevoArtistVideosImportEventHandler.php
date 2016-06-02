<?php

namespace Jukebox\Backend\EventHandlers\Import
{

    use Jukebox\Backend\Commands\InsertTrackArtistCommand;
    use Jukebox\Backend\Commands\InsertTrackCommand;
    use Jukebox\Backend\Commands\InsertTrackGenreCommand;
    use Jukebox\Backend\EventHandlers\EventHandlerInterface;
    use Jukebox\Backend\Events\VevoArtistVideosImportEvent;
    use Jukebox\Backend\Queries\FetchArtistByVevoIdBackendQuery;
    use Jukebox\Backend\Queries\FetchGenreByNameQuery;
    use Jukebox\Backend\Queries\FetchTrackByVevoIdQuery;
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
         * @var FetchGenreByNameQuery
         */
        private $fetchGenreByNameQuery;

        /**
         * @var FetchTrackByVevoIdQuery
         */
        private $fetchTrackByVevoIdQuery;

        private $videoIds = [];

        /**
         * @var string
         */
        private $artistId;

        public function __construct(
            VevoArtistVideosImportEvent $event,
            Vevo $vevo,
            FetchArtistByVevoIdBackendQuery $fetchArtistByVevoIdQuery,
            InsertTrackCommand $insertTrackCommand,
            InsertTrackArtistCommand $insertTrackArtistsCommand,
            InsertTrackGenreCommand $insertTrackGenreCommand,
            FetchGenreByNameQuery $fetchGenreByNameQuery,
            FetchTrackByVevoIdQuery $fetchTrackByVevoIdQuery
        )
        {
            $this->event = $event;
            $this->vevo = $vevo;
            $this->fetchArtistByVevoIdQuery = $fetchArtistByVevoIdQuery;
            $this->insertTrackCommand = $insertTrackCommand;
            $this->insertTrackArtistsCommand = $insertTrackArtistsCommand;
            $this->insertTrackGenreCommand = $insertTrackGenreCommand;
            $this->fetchGenreByNameQuery = $fetchGenreByNameQuery;
            $this->fetchTrackByVevoIdQuery = $fetchTrackByVevoIdQuery;
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
                        break;
                    }
                }

                $id = $this->insertTrackCommand->execute(
                    $video['duration'] * 1000,
                    $video['title'],
                    $video['youTubeId'],
                    $video['isrc'],
                    $video['isLive'],
                    $permalink
                );

                foreach ($video['artists'] as $artist) {
                    try {
                        $this->handleArtist($id, $artist);
                    } catch (\Throwable $e) {
                        $this->getLogger()->emergency($e);
                    }
                }

                if (isset($video['genres'])) {
                    foreach ($video['genres'] as $genre) {
                        try {
                            $this->insertTrackGenreCommand->execute(
                                $id,
                                $this->fetchGenreByNameQuery->execute($genre)['id']
                            );
                        } catch (\Throwable $e) {
                            $this->getLogger()->emergency($e);
                        }
                    }
                }
            } catch (\Throwable $e) {
                $this->getLogger()->critical($e);
            }
        }

        private function handleArtist($trackID, array $artist)
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

            if ($artist['urlSafeName'] === $this->event->getArtist()) {
                if ($this->artistId === null) {
                    $this->artistId = $this->fetchArtistByVevoIdQuery->execute($artist['urlSafeName'])['id'];
                }
                $artistId = $this->artistId;
            } else {
                $artistId = $this->fetchArtistByVevoIdQuery->execute($artist['urlSafeName'])['id'];
            }

            $this->insertTrackArtistsCommand->execute($trackID, $artistId, $role);
        }

        private function handleVideoIds(array $videos)
        {
            foreach ($videos as $video) {
                $this->videoIds[] = $video['isrc'];
            }
        }
    }
}

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
    use Jukebox\Backend\Queries\FetchArtistByVevoIdQuery;
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
         * @var InsertTrackCommand
         */
        private $insertTrackCommand;

        /**
         * @var FetchTrackByVevoIdQuery
         */
        private $fetchTrackByVevoIdQuery;

        private $videoIds = [];


        public function __construct(
            VevoArtistVideosImportEvent $event,
            Vevo $vevo,
            FetchTrackByVevoIdQuery $fetchTrackByVevoIdQuery,
            InsertTrackCommand $insertTrackCommand
        )
        {
            $this->event = $event;
            $this->vevo = $vevo;
            $this->fetchTrackByVevoIdQuery = $fetchTrackByVevoIdQuery;
            $this->insertTrackCommand = $insertTrackCommand;
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

                $title = $video['title'];

                $isAudio = false;
                if (strpos($video['title'], '(Audio)') !== false) {
                    $isAudio = true;
                }

                if (strpos($video['title'], '[Audio]') !== false) {
                    $isAudio = true;
                }

                if (strpos($video['title'], '(AUDIO)') !== false) {
                    $isAudio = true;
                }

                $replace = [
                    '[Official Video]',
                    '[Audio]',
                    '(Audio)',
                    '(AUDIO)',
                    '(Explicit Video)',
                    '(Explicit)',
                    '(Official Explicit Video)',
                    '(Official Video)',
                    '(official video)',
                    '[Official Video]',
                    '(Official Lyric Video)',
                    '(Official Music Video)',
                    '(Official Pseudo Video)',
                    '(LYRIC VIDEO)',
                    '(lyric)',
                    '(Lyric Video)',
                    '[Lyric]',
                    '(VIDEO LYRIC)',
                    '(Lyric Video/Live)',
                    '(Live/Lyric Video)',
                    '(Lyric video - LIVE)',
                    '(Live Lyric Video)',
                    '(Lyric Video/Live)',
                    '[Lyric Video]',
                    '[Official Lyric Video]',
                    'Lyric video',
                    '[]',
                    '()',
                ];

                $title = trim(str_replace($replace, '', $title));

                $track = new Track(
                    $video['duration'] * 1000,
                    $title,
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
                
                $genres = [];
                if (isset($video['genres'])) {
                    $genres = $video['genres'];
                }

                $this->insertTrackCommand->execute($track, $sources, $genres, $artists);

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

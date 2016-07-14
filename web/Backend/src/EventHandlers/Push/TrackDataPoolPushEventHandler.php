<?php

namespace Jukebox\Backend\EventHandlers\Push
{

    use Jukebox\Backend\EventHandlers\EventHandlerInterface;
    use Jukebox\Backend\Events\TrackDataPoolPushEvent;
    use Jukebox\Backend\Queries\FetchTrackArtistsQuery;
    use Jukebox\Backend\Queries\FetchTrackByIdQuery;
    use Jukebox\Backend\Queries\FetchTrackGenresQuery;
    use Jukebox\Backend\Queries\FetchTrackSourcesQuery;
    use Jukebox\Framework\DataPool\DataPoolWriter;
    use Jukebox\Framework\Logging\LoggerAware;
    use Jukebox\Framework\Logging\LoggerAwareTrait;

    class TrackDataPoolPushEventHandler implements EventHandlerInterface, LoggerAware
    {
        use LoggerAwareTrait;

        /**
         * @var TrackDataPoolPushEvent
         */
        private $event;

        /**
         * @var FetchTrackByIdQuery
         */
        private $fetchTrackByIdQuery;

        /**
         * @var FetchTrackArtistsQuery
         */
        private $fetchTrackArtistsQuery;

        /**
         * @var FetchTrackGenresQuery
         */
        private $fetchTrackGenresQuery;

        /**
         * @var FetchTrackSourcesQuery
         */
        private $fetchTrackSourcesQuery;

        /**
         * @var DataPoolWriter
         */
        private $dataPoolWriter;

        public function __construct(
            TrackDataPoolPushEvent $event,
            FetchTrackByIdQuery $fetchTrackByIdQuery,
            FetchTrackArtistsQuery $fetchTrackArtistsQuery,
            FetchTrackGenresQuery $fetchTrackGenresQuery,
            FetchTrackSourcesQuery $fetchTrackSourcesQuery,
            DataPoolWriter $dataPoolWriter
        )
        {
            $this->event = $event;
            $this->fetchTrackByIdQuery = $fetchTrackByIdQuery;
            $this->fetchTrackArtistsQuery = $fetchTrackArtistsQuery;
            $this->fetchTrackGenresQuery = $fetchTrackGenresQuery;
            $this->fetchTrackSourcesQuery = $fetchTrackSourcesQuery;
            $this->dataPoolWriter = $dataPoolWriter;
        }

        public function execute()
        {
            try {
                $track = $this->fetchTrackByIdQuery->execute($this->event->getTrackId());

                $artists = $this->fetchTrackArtistsQuery->execute($track['id']);
                $genres = $this->fetchTrackGenresQuery->execute($track['id']);
                $sources = $this->fetchTrackSourcesQuery->execute($track['id']);

                $data = [
                    'id' => $track['id'],
                    'title' => $track['title'],
                    'duration' => $track['duration'],
                    'isrc' => $track['isrc'],
                    'is_live' => $track['is_live'],
                    'is_lyric' => $track['is_lyric'],
                    'is_music_video' => $track['is_music_video'],
                    'is_audio' => $track['is_audio'],
                    'is_explicit' => $track['is_explicit'],
                    'permalink' => $track['permalink'],
                    'release_date' => $track['release_date'],
                    'artists' => $artists,
                    'genres' => $genres,
                    'sources' => $sources,
                    'type' => 'tracks'
                ];

                $this->dataPoolWriter->setTrack($track['id'], $data);
            } catch (\Throwable $e) {
                $this->getLogger()->critical($e);
            }
        }
    }
}

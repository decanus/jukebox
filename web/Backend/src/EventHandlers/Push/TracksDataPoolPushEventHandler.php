<?php

namespace Jukebox\Backend\EventHandlers\Push
{

    use Jukebox\Backend\EventHandlers\EventHandlerInterface;
    use Jukebox\Backend\Queries\FetchTrackArtistsQuery;
    use Jukebox\Backend\Queries\FetchTrackGenresQuery;
    use Jukebox\Backend\Queries\FetchTrackSourcesQuery;
    use Jukebox\Backend\Queries\FetchTracksQuery;
    use Jukebox\Framework\DataPool\DataPoolWriter;

    class TracksDataPoolPushEventHandler implements EventHandlerInterface
    {
        /**
         * @var DataPoolWriter
         */
        private $dataPoolWriter;

        /**
         * @var FetchTracksQuery
         */
        private $fetchTracksQuery;

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

        public function __construct(
            DataPoolWriter $dataPoolWriter,
            FetchTracksQuery $fetchTracksQuery,
            FetchTrackArtistsQuery $fetchTrackArtistsQuery,
            FetchTrackGenresQuery $fetchTrackGenresQuery,
            FetchTrackSourcesQuery $fetchTrackSourcesQuery
        )
        {
            $this->dataPoolWriter = $dataPoolWriter;
            $this->fetchTracksQuery = $fetchTracksQuery;
            $this->fetchTrackArtistsQuery = $fetchTrackArtistsQuery;
            $this->fetchTrackGenresQuery = $fetchTrackGenresQuery;
            $this->fetchTrackSourcesQuery = $fetchTrackSourcesQuery;
        }

        public function execute()
        {
            $tracks = $this->fetchTracksQuery->execute();

            foreach ($tracks as $key => $track) {
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
                    'type' => 'artists'
                ];

                $this->dataPoolWriter->setTrack($track['id'], $data);
            }
        }
    }
}

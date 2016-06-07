<?php

namespace Jukebox\Backend\EventHandlers\Push
{

    use Elasticsearch\Client;
    use Jukebox\Backend\EventHandlers\EventHandlerInterface;
    use Jukebox\Backend\Events\TracksToElasticsearchPushEvent;
    use Jukebox\Backend\Queries\FetchTrackArtistsQuery;
    use Jukebox\Backend\Queries\FetchTrackGenresQuery;
    use Jukebox\Backend\Queries\FetchTrackSourcesQuery;
    use Jukebox\Backend\Queries\FetchTracksQuery;

    class TracksToElasticsearchPushEventHandler implements EventHandlerInterface
    {
        /**
         * @var TracksToElasticsearchPushEvent
         */
        private $event;

        /**
         * @var Client
         */
        private $client;

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
            TracksToElasticsearchPushEvent $event,
            Client $client,
            FetchTracksQuery $fetchTracksQuery,
            FetchTrackArtistsQuery $fetchTrackArtistsQuery,
            FetchTrackGenresQuery $fetchTrackGenresQuery,
            FetchTrackSourcesQuery $fetchTrackSourcesQuery
        )
        {
            $this->event = $event;
            $this->client = $client;
            $this->fetchTracksQuery = $fetchTracksQuery;
            $this->fetchTrackArtistsQuery = $fetchTrackArtistsQuery;
            $this->fetchTrackGenresQuery = $fetchTrackGenresQuery;
            $this->fetchTrackSourcesQuery = $fetchTrackSourcesQuery;
        }

        public function execute()
        {
            $tracks = $this->fetchTracksQuery->execute();

            foreach ($tracks as $track) {

                $artists = $this->fetchTrackArtistsQuery->execute($track['id']);
                $genres = $this->fetchTrackGenresQuery->execute($track['id']);
                $sources = $this->fetchTrackSourcesQuery->execute($track['id']);

                $params = [
                    'index' => $this->event->getDataVersion(),
                    'type' => 'tracks',
                    'id' => $track['id'],
                    'body' => [
                        'title' => $track['title'],
                        'duration' => $track['duration'],
                        'vevo_id' => $track['vevo_id'],
                        'isrc' => $track['isrc'],
                        'is_live' => $track['is_live'],
                        'is_explicit' => $track['is_explicit'],
                        'permalink' => $track['permalink'],
                        'artists' => $artists,
                        'genres' => $genres,
                        'sources' => $sources
                    ]
                ];

                $this->client->index($params);
            }
        }
    }
}

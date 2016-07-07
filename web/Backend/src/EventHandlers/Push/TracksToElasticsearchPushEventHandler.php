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

        public function __construct(
            TracksToElasticsearchPushEvent $event,
            Client $client,
            FetchTracksQuery $fetchTracksQuery,
            FetchTrackArtistsQuery $fetchTrackArtistsQuery
        )
        {
            $this->event = $event;
            $this->client = $client;
            $this->fetchTracksQuery = $fetchTracksQuery;
            $this->fetchTrackArtistsQuery = $fetchTrackArtistsQuery;
        }

        public function execute()
        {
            $tracks = $this->fetchTracksQuery->execute();
            $params = ['body' => []];

            foreach ($tracks as $key => $track) {
                $params['body'][] = [
                    'index' => [
                        '_index' => (string) $this->event->getDataVersion(),
                        '_type' => 'tracks',
                        '_id' => $track['id']
                    ]
                ];

                $artists = $this->fetchTrackArtistsQuery->execute($track['id'], true);

                $params['body'][] = [
                    'title' => $track['title'],
                    'release_date' => $track['release_date'],
                    'artists' => $artists
                ];

                if ($key % 1000 === 0) {
                    $this->client->bulk($params);
                    $params = ['body' => []];
                }
            }

            if (!empty($params['body'])) {
                $this->client->bulk($params);
            }

            $this->client->indices()->putSettings(
                [
                    'index' => (string) $this->event->getDataVersion(),
                    'body' => [
                        'settings' => [
                            'refresh_interval' => '-1'
                        ]
                    ]
                ]
            );

            $this->client->indices()->forceMerge(['index' => (string) $this->event->getDataVersion()]);
        }
    }
}

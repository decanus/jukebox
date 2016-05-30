<?php

namespace Jukebox\Backend\EventHandlers\Push
{

    use Elasticsearch\Client;
    use Jukebox\Backend\EventHandlers\EventHandlerInterface;
    use Jukebox\Backend\Events\TracksToElasticsearchPushEvent;
    use Jukebox\Backend\Queries\FetchTrackArtistsQuery;
    use Jukebox\Backend\Queries\FetchTrackGenresQuery;
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

        public function __construct(
            TracksToElasticsearchPushEvent $event,
            Client $client,
            FetchTracksQuery $fetchTracksQuery,
            FetchTrackArtistsQuery $fetchTrackArtistsQuery,
            FetchTrackGenresQuery $fetchTrackGenresQuery
        )
        {
            $this->event = $event;
            $this->client = $client;
            $this->fetchTracksQuery = $fetchTracksQuery;
            $this->fetchTrackArtistsQuery = $fetchTrackArtistsQuery;
            $this->fetchTrackGenresQuery = $fetchTrackGenresQuery;
        }

        public function execute()
        {
            $tracks = $this->fetchTracksQuery->execute();

            foreach ($tracks as $track) {
                $artists = $this->fetchTrackArtistsQuery->execute($track['id']);
                $genres = $this->fetchTrackGenresQuery->execute($track['id']);
                
                $params = [
                    'index' => $this->event->getDataVersion(),
                    'type' => 'tracks',
                    'id' => $track['id'],
                    'body' => [
                        'title' => $track['title'],
                        'duration' => $track['duration'],
                        'youtube_id' => $track['youtube_id'],
                        'vevo_id' => $track['vevo_id'],
                        'is_live' => $track['is_live'],
                        'artists' => $artists,
                        'genres' => $genres
                    ]
                ];

                $this->client->index($params);
            }
        }
    }
}

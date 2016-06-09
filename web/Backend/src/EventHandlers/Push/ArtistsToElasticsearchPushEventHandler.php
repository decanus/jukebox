<?php

namespace Jukebox\Backend\EventHandlers\Push
{

    use Elasticsearch\Client;
    use Jukebox\Backend\EventHandlers\EventHandlerInterface;
    use Jukebox\Backend\Events\ArtistsToElasticsearchPushEvent;
    use Jukebox\Backend\Queries\FetchArtistsQuery;
    use Jukebox\Framework\Logging\LoggerAware;
    use Jukebox\Framework\Logging\LoggerAwareTrait;

    class ArtistsToElasticsearchPushEventHandler implements EventHandlerInterface, LoggerAware
    {
        /**
         * @trait
         */
        use LoggerAwareTrait;

        /**
         * @var ArtistsToElasticsearchPushEvent
         */
        private $event;

        /**
         * @var Client
         */
        private $elasticsearchClient;
        
        /**
         * @var FetchArtistsQuery
         */
        private $fetchArtistsQuery;

        public function __construct(
            ArtistsToElasticsearchPushEvent $event,
            Client $elasticsearchClient,
            FetchArtistsQuery $fetchArtistsQuery
        )
        {
            $this->elasticsearchClient = $elasticsearchClient;
            $this->fetchArtistsQuery = $fetchArtistsQuery;
            $this->event = $event;
        }

        public function execute()
        {
            $artists = $this->fetchArtistsQuery->execute();
            $params = ['body' => []];

            foreach ($artists as $key => $artist) {
                $params['body'][] = [
                    'index' => [
                        '_index' => (string) $this->event->getDataVersion(),
                        '_type' => 'artists',
                        '_id' => $artist['id']
                    ]
                ];

                $params['body'][] = [
                    'name' => $artist['name'],
                    'vevo_id' => $artist['vevo_id'],
                    'official_website' => $artist['official_website'],
                    'twitter' => $artist['twitter'],
                    'facebook' => $artist['facebook'],
                    'itunes' => $artist['itunes'],
                    'amazon' => $artist['amazon'],
                    'permalink' => $artist['permalink'],
                ];

                if ($key % 1000 === 0) {
                    $this->elasticsearchClient->bulk($params);
                    $params = ['body' => []];
                }
            }

            if (!empty($params['body'])) {
                 $this->elasticsearchClient->bulk($params);
            }
        }
    }
}

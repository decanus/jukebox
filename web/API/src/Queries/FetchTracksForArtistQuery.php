<?php

namespace Jukebox\API\Queries
{

    use Elasticsearch\Client;

    class FetchTracksForArtistQuery
    {
        /**
         * @var Client
         */
        private $client;

        /**
         * @param Client $client
         */
        public function __construct(Client $client)
        {
            $this->client = $client;
        }

        /**
         * @param string $artist
         * @return array
         */
        public function execute(string $artist)
        {
            $params = [
                'index' => '20160530-2130',
                'type' => 'tracks',
                'size' => 5,
                'body' => [
                    'query' => [
                        'bool' => [
                            'must' => ['match' => ['artists.id' => $artist]]
                        ]
                    ]
                ]
            ];

            return $this->client->search($params);
        }
    }
}

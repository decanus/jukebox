<?php

namespace Jukebox\API\Queries
{

    use Elasticsearch\Client;

    class FetchArtistQuery
    {
        /**
         * @var Client
         */
        private $client;

        public function __construct(Client $client)
        {
            $this->client = $client;
        }

        public function execute(string $id)
        {
            return $this->client->get(['index' => '20160530-2130', 'type' => 'artists', 'id' => $id]);
        }
    }
}

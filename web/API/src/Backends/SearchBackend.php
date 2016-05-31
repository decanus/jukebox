<?php

namespace Jukebox\API\Backends
{

    use Elasticsearch\Client;
    use Jukebox\API\Search\SearchResult;
    use Jukebox\Framework\ValueObjects\DataVersion;

    class SearchBackend
    {
        /**
         * @var DataVersion
         */
        private $dataVersion;

        /**
         * @var Client
         */
        private $client;

        public function __construct(DataVersion $dataVersion, Client $client)
        {
            $this->dataVersion = $dataVersion;
            $this->client = $client;
        }

        public function getArtist(string $id): SearchResult
        {
            return $this->getDocument('artists', $id);
        }

        public function getTrack(string $id): SearchResult
        {
            return $this->getDocument('tracks', $id);
        }

        public function search(string $type, array $query): SearchResult
        {
            return new SearchResult($this->client->search(['index' => $this->dataVersion, 'type' => $type, 'body' => $query]));
        }

        private function getDocument(string $type, string $id): SearchResult
        {
            return new SearchResult($this->client->get(['index' => $this->dataVersion, 'type' => $type, 'id' => $id]));
        }
    }
}

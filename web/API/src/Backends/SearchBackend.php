<?php

namespace Jukebox\API\Backends
{

    use Elasticsearch\Client;
    use Jukebox\API\Mappers\SearchResultMapper;
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

        /**
         * @var SearchResultMapper
         */
        private $searchResultMapper;

        public function __construct(
            DataVersion $dataVersion,
            Client $client,
            SearchResultMapper $searchResultMapper
        )
        {
            $this->dataVersion = $dataVersion;
            $this->client = $client;
            $this->searchResultMapper = $searchResultMapper;
        }

        public function getArtist(string $id): array
        {
            return $this->getDocument('artists', $id);
        }

        public function getTrack(string $id): array
        {
            return $this->getDocument('tracks', $id);
        }

        public function search(string $type, array $query, $size = 10000): array
        {
            return $this->searchResultMapper->map(new SearchResult($this->client->search(['index' => $this->dataVersion, 'type' => $type, 'body' => $query, 'size' => $size])));
        }

        private function getDocument(string $type, string $id): array
        {
            return $this->searchResultMapper->map(new SearchResult($this->client->get(['index' => $this->dataVersion, 'type' => $type, 'id' => $id])));
        }
    }
}

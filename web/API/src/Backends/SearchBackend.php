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

        public function search(string $type, array $query, int $size = 20, int $page = 1): array
        {
            $from = 0;
            if ($page > 1) {
                $from = (($page - 1) * $size) + 1;
            }
            
            return $this->searchResultMapper->map(
                new SearchResult(
                    $this->client->search(['index' => $this->dataVersion, 'type' => $type, 'body' => $query, 'size' => $size, 'from' => $from]),
                    $size,
                    $page
                )
            );
        }
    }
}

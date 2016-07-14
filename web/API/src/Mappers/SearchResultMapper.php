<?php

namespace Jukebox\API\Mappers
{

    use Jukebox\API\Search\SearchResult;
    use Jukebox\Framework\DataPool\DataPoolReader;

    class SearchResultMapper
    {
        /**
         * @var DataPoolReader
         */
        private $dataPoolReader;

        public function __construct(DataPoolReader $dataPoolReader)
        {
            $this->dataPoolReader = $dataPoolReader;
        }

        public function map(SearchResult $searchResult): array
        {
            $response = [];

            if ($searchResult->found()) {
                $hit = $searchResult->getResponse();
                if ($hit['_type'] === 'artists') {
                    return $this->dataPoolReader->getArtist($hit['_id']);
                }

                if ($hit['_type'] === 'tracks') {
                    return $this->dataPoolReader->getTrack($hit['_id']);
                }
            }


            if (!$searchResult->hasHits()) {
                return [];
            }

            $result = [];
            foreach ($searchResult->getHits() as $hit) {
                if ($hit['_type'] === 'artists') {
                    try {
                        $result[] = $this->dataPoolReader->getArtist($hit['_id']);
                    } catch (\Throwable $e) {
                        // @todo
                    }
                    continue;
                }

                if ($hit['_type'] === 'tracks') {
                    try {
                        $result[] = $this->dataPoolReader->getTrack($hit['_id']);
                    } catch (\Exception $e) {

                    }
                }

            }

            if ($searchResult->hasPagination()) {
                $response['pagination'] = $searchResult->getPagination();
            }

            $response['results'] = $result;

            return $response;
        }
    }
}

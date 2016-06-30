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
                return $this->normalize($searchResult->getResponse());
            }


            if (!$searchResult->hasHits()) {
                return [];
            }

            $result = [];
            foreach ($searchResult->getHits() as $hit) {
                if ($hit['_type'] === 'artists') {
                    $result[] = $this->dataPoolReader->getArtist($hit['_id']);
                    continue;
                }


                $result[] = $this->normalize($hit);
            }

            if ($searchResult->hasPagination()) {
                $response['pagination'] = $searchResult->getPagination();
            }

            $response['results'] = $result;

            return $response;
        }

        private function normalize(array $object)
        {
            $data = $object['_source'];
            $data['id'] = (int) $object['_id'];
            $data['type'] = $object['_type'];

            if (isset($object['_score'])) {
                $data['score'] = $object['_score'];
            }

            return $data;
        }
    }
}

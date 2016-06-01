<?php

namespace Jukebox\API\Mappers
{

    use Jukebox\API\Search\SearchResult;

    class SearchResultMapper
    {
        public function map(SearchResult $searchResult): array
        {
            if ($searchResult->found()) {
                return $this->normalize($searchResult->getResponse());
            }


            if (!$searchResult->hasHits()) {
                return [];
            }

            $result = [];
            foreach ($searchResult->getHits() as $hit) {
                $result[] = $this->normalize($hit);
            }

            return $result;
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

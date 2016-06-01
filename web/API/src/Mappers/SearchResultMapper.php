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

            return [];
        }

        private function normalize(array $object)
        {
            $data = $object['_source'];
            $data['id'] = $object['_id'];
            $data['type'] = $object['_type'];

            return $data;
        }
    }
}

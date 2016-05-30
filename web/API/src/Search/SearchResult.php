<?php

namespace Jukebox\API\Search
{
    class SearchResult
    {
        private $response;

        public function __construct(array $response = [])
        {
            $this->response = $response;
        }
        
        public function wasFound(): bool
        {
            if (!isset($this->response['found'])) {
                return false;
            }

            return $this->response['found'];
        }

        public function hasHits(): bool
        {
            return $this->getNumberOfHits() > 0;
        }

        public function getNumberOfHits(): int
        {
            if (!isset($this->response['hits'])) {
                return 0;
            }

            return $this->response['hits']['total'];
        }
    }
}

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
        
        public function found(): bool
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

        public function getPagination(): array
        {

        }

        public function getResponse(): array
        {
            return $this->response;
        }

        public function getHits(): array
        {
            return $this->response['hits']['hits'];
        }
    }
}

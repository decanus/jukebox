<?php

namespace Jukebox\API\Search
{
    class SearchResult
    {
        private $response;

        /**
         * @var int
         */
        private $size;

        /**
         * @var int
         */
        private $page;

        public function __construct(array $response = [], $size = 0, $page = 1)
        {
            $this->response = $response;
            $this->size = $size;
            $this->page = $page;
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
            if ($this->size === 0 && $this->page === 0) {
                return;
            }

            return [
                'size' => $this->size,
                'page' => $this->page,
                'pages' => ceil($this->getNumberOfHits() / $this->size)
            ];
        }

        public function hasPagination(): bool
        {
            if ($this->size === 0 && $this->page === 1) {
                return false;
            }

            return true;
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

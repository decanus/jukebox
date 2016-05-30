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
    }
}

<?php

namespace Jukebox\API\Queries
{

    use Jukebox\API\Backends\SearchBackend;

    class FetchTrackByIdQuery
    {
        /**
         * @var SearchBackend
         */
        private $searchBackend;

        public function __construct(SearchBackend $searchBackend)
        {
            $this->searchBackend = $searchBackend;
        }

        public function execute(string $id)
        {
            return $this->searchBackend->getTrack($id);
        }
    }
}

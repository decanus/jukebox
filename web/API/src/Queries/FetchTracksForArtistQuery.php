<?php

namespace Jukebox\API\Queries
{

    use Jukebox\API\Backends\SearchBackend;

    class FetchTracksForArtistQuery
    {
        /**
         * @var SearchBackend
         */
        private $searchBackend;

        public function __construct(SearchBackend $searchBackend)
        {
            $this->searchBackend = $searchBackend;
        }

        /**
         * @param string $artist
         * @param int $size
         * @param int $from
         * 
         * @return array
         */
        public function execute(string $artist, int $size, int $from)
        {
            $params = [
                'query' => [
                    'bool' => [
                        'must' => ['match' => ['artists.id' => $artist]]
                    ]
                ]
            ];
            
            return $this->searchBackend->search('tracks', $params, $size, $from);
        }
    }
}

<?php

namespace Jukebox\API\Factories
{

    use Jukebox\Framework\Factories\AbstractFactory;

    class QueryFactory extends AbstractFactory
    {
        public function createFetchArtistQuery(): \Jukebox\API\Queries\FetchArtistQuery
        {
            return new \Jukebox\API\Queries\FetchArtistQuery(
                $this->getMasterFactory()->createPostgreDatabaseBackend()
            );
        }

        public function createFetchTracksForArtistQuery(): \Jukebox\API\Queries\FetchTracksForArtistQuery
        {
            return new \Jukebox\API\Queries\FetchTracksForArtistQuery(
                $this->getMasterFactory()->createPostgreDatabaseBackend()
            );
        }
    }
}

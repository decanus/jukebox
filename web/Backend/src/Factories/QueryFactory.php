<?php

namespace Jukebox\Backend\Factories
{

    use Jukebox\Framework\Factories\AbstractFactory;

    class QueryFactory extends AbstractFactory
    {
        public function createFetchArtistByVevoIdQuery(): \Jukebox\Backend\Queries\FetchArtistByVevoIdQuery
        {
            return new \Jukebox\Backend\Queries\FetchArtistByVevoIdQuery(
                $this->getMasterFactory()->createPostgreDatabaseBackend()
            );
        }
        
        public function createFetchGenreByNameQuery(): \Jukebox\Backend\Queries\FetchGenreByNameQuery
        {
            return new \Jukebox\Backend\Queries\FetchGenreByNameQuery(
                $this->getMasterFactory()->createPostgreDatabaseBackend()
            );
        }
        
        public function createFetchTrackByVevoIdQuery(): \Jukebox\Backend\Queries\FetchTrackByVevoIdQuery
        {
            return new \Jukebox\Backend\Queries\FetchTrackByVevoIdQuery(
                $this->getMasterFactory()->createPostgreDatabaseBackend()
            );
        }

        public function createFetchVevoArtistsQuery(): \Jukebox\Backend\Queries\FetchVevoArtistsQuery
        {
            return new \Jukebox\Backend\Queries\FetchVevoArtistsQuery(
                $this->getMasterFactory()->createPostgreDatabaseBackend()
            );
        }

        public function createFetchArtistsQuery(): \Jukebox\Backend\Queries\FetchArtistsQuery
        {
            return new \Jukebox\Backend\Queries\FetchArtistsQuery(
                $this->getMasterFactory()->createPostgreDatabaseBackend()
            );
        }
    }
}

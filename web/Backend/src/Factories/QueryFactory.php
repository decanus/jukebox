<?php

namespace Jukebox\Backend\Factories
{

    use Jukebox\Framework\Factories\AbstractFactory;

    class QueryFactory extends AbstractFactory
    {
        public function createFetchArtistByVevoIdQuery(): \Jukebox\Backend\Queries\FetchArtistByVevoIdBackendQuery
        {
            return new \Jukebox\Backend\Queries\FetchArtistByVevoIdBackendQuery(
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

        public function createFetchTracksQuery(): \Jukebox\Backend\Queries\FetchTracksQuery
        {
            return new \Jukebox\Backend\Queries\FetchTracksQuery(
                $this->getMasterFactory()->createPostgreDatabaseBackend()
            );
        }

        public function createFetchTrackArtistsQuery(): \Jukebox\Backend\Queries\FetchTrackArtistsQuery
        {
            return new \Jukebox\Backend\Queries\FetchTrackArtistsQuery(
                $this->getMasterFactory()->createPostgreDatabaseBackend()
            );
        }

        public function createFetchTrackGenresQuery(): \Jukebox\Backend\Queries\FetchTrackGenresQuery
        {
            return new \Jukebox\Backend\Queries\FetchTrackGenresQuery(
                $this->getMasterFactory()->createPostgreDatabaseBackend()
            );
        }

        public function createFetchTrackPathsQuery(): \Jukebox\Backend\Queries\FetchTrackPathsQuery
        {
            return new \Jukebox\Backend\Queries\FetchTrackPathsQuery(
                $this->getMasterFactory()->createPostgreDatabaseBackend()
            );
        }
    }
}

<?php

namespace Jukebox\API\Factories
{

    use Jukebox\Framework\Factories\AbstractFactory;

    class QueryFactory extends AbstractFactory
    {
        public function createFetchArtistQuery(): \Jukebox\API\Queries\FetchArtistQuery
        {
            return new \Jukebox\API\Queries\FetchArtistQuery(
                $this->getMasterFactory()->createDataPoolReader()
            );
        }

        public function createFetchTracksForArtistQuery(): \Jukebox\API\Queries\FetchTracksForArtistQuery
        {
            return new \Jukebox\API\Queries\FetchTracksForArtistQuery(
                $this->getMasterFactory()->createSearchBackend()
            );
        }

        public function createFetchTrackByIdQuery(): \Jukebox\API\Queries\FetchTrackByIdQuery
        {
            return new \Jukebox\API\Queries\FetchTrackByIdQuery(
                $this->getMasterFactory()->createDataPoolReader()
            );
        }

        public function createFetchUserByEmailQuery(): \Jukebox\API\Queries\FetchUserByEmailQuery
        {
            return new \Jukebox\API\Queries\FetchUserByEmailQuery(
                $this->getMasterFactory()->createPostgreDatabaseBackend()
            );
        }

        public function createFetchUserPlaylistsQuery(): \Jukebox\API\Queries\FetchUserPlaylistsQuery
        {
            return new \Jukebox\API\Queries\FetchUserPlaylistsQuery(
                $this->getMasterFactory()->createMongoDatabaseBackend()
            );
        }

        public function createFetchPublicUserQuery(): \Jukebox\API\Queries\FetchPublicUserQuery
        {
            return new \Jukebox\API\Queries\FetchPublicUserQuery(
                $this->getMasterFactory()->createMongoDatabaseBackend()
            );
        }

        public function createFetchUserPlaylistQuery(): \Jukebox\API\Queries\FetchUserPlaylistQuery
        {
            return new \Jukebox\API\Queries\FetchUserPlaylistQuery(
                $this->getMasterFactory()->createMongoDatabaseBackend()
            );
        }
    }
}

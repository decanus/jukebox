<?php

namespace Jukebox\Backend\Factories
{

    use Jukebox\Framework\Factories\AbstractFactory;

    class QueryFactory extends AbstractFactory
    {
        public function createFetchArtistByVevoIdQuery()
        {
            return new \Jukebox\Backend\Queries\FetchArtistByVevoIdQuery(
                $this->getMasterFactory()->createPostgreDatabaseBackend()
            );
        }
        
        public function createFetchGenreByNameQuery()
        {
            return new \Jukebox\Backend\Queries\FetchGenreByNameQuery(
                $this->getMasterFactory()->createPostgreDatabaseBackend()
            );
        }
    }
}

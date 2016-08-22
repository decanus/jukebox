<?php

namespace Jukebox\Backend\Queries
{
    class FetchArtistByIdQuery extends AbstractDatabaseBackendQuery
    {

        /**
         * @param string $id
         * 
         * @return mixed
         */
        public function execute(string $id)
        {
            return $this->getDatabaseBackend()->fetch(
                'SELECT * FROM artists WHERE id = :id',
                [':id' => $id]
            );
        }
    }
}

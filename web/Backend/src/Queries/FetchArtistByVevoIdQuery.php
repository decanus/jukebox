<?php

namespace Jukebox\Backend\Queries
{
    class FetchArtistByVevoIdQuery extends AbstractDatabaseBackendQuery
    {

        /**
         * @param $vevoId
         * 
         * @return mixed
         */
        public function execute($vevoId)
        {
            return $this->getDatabaseBackend()->fetch(
                'SELECT * FROM artists WHERE vevo_id = :vevo_id',
                [':vevo_id' => $vevoId]
            );
        }
    }
}

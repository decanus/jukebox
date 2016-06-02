<?php

namespace Jukebox\Backend\Queries
{
    class FetchTrackByVevoIdQuery extends AbstractDatabaseBackendQuery
    {
        /**
         * @param $vevoId
         *
         * @return mixed
         */
        public function execute($vevoId)
        {
            return $this->getDatabaseBackend()->fetch(
                'SELECT * FROM tracks WHERE vevo_id = :vevo_id',
                [':vevo_id' => $vevoId]
            );
        }
    }
}

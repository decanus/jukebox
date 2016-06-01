<?php

namespace Jukebox\Backend\Queries
{
    class FetchVevoArtistsQuery extends AbstractDatabaseBackendQuery
    {

        /**
         * @return array
         */
        public function execute()
        {
            return $this->getDatabaseBackend()->fetchAll('SELECT * FROM artists WHERE vevo_id IS NOT NULL');
        }
    }
}

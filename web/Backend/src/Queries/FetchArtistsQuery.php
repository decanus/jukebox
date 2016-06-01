<?php

namespace Jukebox\Backend\Queries
{
    class FetchArtistsQuery extends AbstractDatabaseBackendQuery
    {
        /**
         * @return array
         */
        public function execute()
        {
            return $this->getDatabaseBackend()->fetchAll('SELECT * FROM artists');
        }
    }
}

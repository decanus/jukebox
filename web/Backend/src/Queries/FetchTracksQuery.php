<?php

namespace Jukebox\Backend\Queries
{
    class FetchTracksQuery extends AbstractDatabaseBackendQuery
    {
        /**
         * @return array
         */
        public function execute()
        {
            return $this->getDatabaseBackend()->fetchAll('SELECT * FROM tracks');
        }
    }
}

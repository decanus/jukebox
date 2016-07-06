<?php

namespace Jukebox\Backend\Queries
{

    class FetchTrackIdsQuery extends AbstractDatabaseBackendQuery
    {
        public function execute()
        {
            return $this->getDatabaseBackend()->fetchAll('SELECT id FROM tracks');
        }
    }
}

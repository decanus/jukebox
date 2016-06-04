<?php

namespace Jukebox\Backend\Queries
{
    class FetchTrackPathsQuery extends AbstractDatabaseBackendQuery
    {
        public function execute(): array
        {
            return $this->getDatabaseBackend()->fetchAll('SELECT id, permalink FROM tracks');
        }
    }
}

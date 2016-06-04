<?php

namespace Jukebox\Backend\Queries
{
    class FetchArtistPathsQuery extends AbstractDatabaseBackendQuery
    {
        public function execute(): array
        {
            return $this->getDatabaseBackend()->fetchAll('SELECT id, permalink FROM artists');
        }
    }
}

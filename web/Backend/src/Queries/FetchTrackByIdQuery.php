<?php

namespace Jukebox\Backend\Queries
{
    class FetchTrackByIdQuery extends AbstractDatabaseBackendQuery
    {
        public function execute(string $trackId)
        {
            return $this->getDatabaseBackend()->fetch('SELECT * FROM tracks WHERE id = :id', [':id' => $trackId]);
        }
    }
}

<?php

namespace Jukebox\Backend\Queries
{
    class FetchTrackServicesQuery extends AbstractDatabaseBackendQuery
    {
        public function execute(int $track)
        {
            return $this->getDatabaseBackend()->fetchAll('SELECT duration, source, source_data FROM track_sources WHERE track = :track', [':track' => $track]);
        }
    }
}

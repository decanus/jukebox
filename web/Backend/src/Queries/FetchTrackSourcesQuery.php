<?php

namespace Jukebox\Backend\Queries
{
    class FetchTrackSourcesQuery extends AbstractDatabaseBackendQuery
    {
        public function execute(int $track)
        {
            return $this->getDatabaseBackend()->fetchAll('SELECT source, source_data, duration FROM track_sources WHERE track = :track', [':track' => $track]);
        }
    }
}

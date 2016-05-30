<?php

namespace Jukebox\Backend\Queries
{
    class FetchTrackArtistsQuery extends AbstractDatabaseBackendQuery
    {
        public function execute(string $track)
        {
            return $this->getDatabaseBackend()->fetchAll(
                'SELECT artists.id, artists.name, track_artists.role FROM artists
                  INNER JOIN track_artists ON track_artists.track = artists.id
                  WHERE track_artists.track = :track',
                [':track' => $track]
            );
        }
    }
}

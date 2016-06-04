<?php

namespace Jukebox\Backend\Queries
{
    class FetchTrackArtistsQuery extends AbstractDatabaseBackendQuery
    {
        public function execute(int $track)
        {
            return $this->getDatabaseBackend()->fetchAll(
                'SELECT artists.id, artists.name, artists.permalink, track_artists.role FROM track_artists
                  LEFT JOIN artists ON artists.id = track_artists.artist
                  WHERE track_artists.track = :track',
                [':track' => $track]
            );
        }
    }
}

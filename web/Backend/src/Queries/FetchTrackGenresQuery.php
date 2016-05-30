<?php

namespace Jukebox\Backend\Queries
{
    class FetchTrackGenresQuery extends AbstractDatabaseBackendQuery
    {
        public function execute(string $track)
        {
            return $this->getDatabaseBackend()->fetchAll(
                'SELECT genres.* FROM genres
                  INNER JOIN track_genres ON track_genres.track = genres.id
                  WHERE track_genres.track = :track',
                [':track' => $track]
            );
        }
    }
}

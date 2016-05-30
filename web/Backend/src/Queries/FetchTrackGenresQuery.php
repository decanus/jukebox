<?php

namespace Jukebox\Backend\Queries
{
    class FetchTrackGenresQuery extends AbstractDatabaseBackendQuery
    {
        public function execute(int $track)
        {
            return $this->getDatabaseBackend()->fetchAll(
                'SELECT genres.* FROM track_genres
                  LEFT JOIN genres ON genres.id = track_genres.genre
                  WHERE track_genres.track = :track',
                [':track' => $track]
            );
        }
    }
}

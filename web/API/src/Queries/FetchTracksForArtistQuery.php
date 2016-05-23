<?php

namespace Jukebox\API\Queries
{

    use Jukebox\Framework\Backends\PostgreDatabaseBackend;

    class FetchTracksForArtistQuery
    {
        /**
         * @var PostgreDatabaseBackend
         */
        private $databaseBackend;

        public function __construct(PostgreDatabaseBackend $databaseBackend)
        {
            $this->databaseBackend = $databaseBackend;
        }

        /**
         * @param string $artist
         * @return array
         */
        public function execute(string $artist)
        {
            return $this->databaseBackend->fetchAll(
                'SELECT tracks.*
                  FROM tracks 
                  LEFT JOIN track_artists ON track_artists.track = tracks.id
                  WHERE track_artists.artist = :artist GROUP BY tracks.id',
                [':artist' => $artist]
            );
        }
    }
}

<?php

namespace Jukebox\Backend\Commands
{
    use Jukebox\Framework\ValueObjects\ArtistRole;

    class InsertVevoTrackArtistsCommand extends AbstractDatabaseBackendCommand
    {
        public function execute(string $trackID, string $artistID, ArtistRole $role)
        {
            return $this->getDatabaseBackend()->insert(
                'INSERT INTO track_artists (artist, track, role) VALUES (:artist, :track, :role)',
                [':artist' => $artistID, ':track' => $trackID, ':role' => (string) $role]
            );
        }
    }
}

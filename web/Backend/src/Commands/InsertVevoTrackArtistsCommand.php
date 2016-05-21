<?php

namespace Jukebox\Backend\Commands
{
    use Jukebox\Framework\ValueObjects\ArtistRole;

    class InsertVevoTrackArtistsCommand extends AbstractDatabaseBackendCommand
    {
        public function execute(string $trackID, string $artistID, ArtistRole $role)
        {

        }
    }
}

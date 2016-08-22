<?php

namespace Jukebox\Backend\Commands
{
    class UpdateArtistSoundcloudIdCommand extends AbstractDatabaseBackendCommand
    {
        public function execute(string $artistId, string $soundcloudId): bool
        {
            return $this->getDatabaseBackend()->execute(
                'UPDATE artists SET soundcloud_id = :soundcloud_id WHERE id = :id',
                [':soundcloud_id' => $soundcloudId, ':id' => $artistId]
            );
        }
    }
}

<?php

namespace Jukebox\Backend\Queries
{
    class FetchArtistBySoundcloudIdQuery extends AbstractDatabaseBackendQuery
    {
        public function execute(string $soundcloudId)
        {
            return $this->getDatabaseBackend()->fetch(
                'SELECT * FROM artists WHERE soundcloud_id = :soundcloud_id',
                [':soundcloud_id' => $soundcloudId]
            );
        }
    }
}

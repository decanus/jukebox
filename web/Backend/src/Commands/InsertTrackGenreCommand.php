<?php

namespace Jukebox\Backend\Commands
{
    class InsertTrackGenreCommand extends AbstractDatabaseBackendCommand
    {
        public function execute(string $track, string $genre): bool
        {
            return $this->getDatabaseBackend()->execute(
                'INSERT INTO track_genres (track, genre) VALUES(:track, :genre)',
                [':track' => $track, ':genre' => $genre]
            );
        }
    }
}

<?php

namespace Jukebox\Backend\Commands
{
    class InsertTrackCommand extends AbstractDatabaseBackendCommand
    {
        public function execute(
            int $duration,
            string $title,
            string $youtubeId = null,
            string $vevoId = null,
            bool $isLive = false
        ): bool
        {
            return $this->getDatabaseBackend()->insert(
                'INSERT INTO tracks (duration, title, youtube_id, vevo_id, is_live) VALUES (:duration, :title, :youtube_id, :vevo_id, :is_live)',
                [':duration' => $duration, ':title' => $title, ':youtube_id' => $youtubeId, ':vevo_id' => $vevoId, ':is_live' => $isLive]
            );
        }
    }
}

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
            string $isrc = null,
            bool $isLive = false,
            bool $isExplicit = false,
            string $permalink
        ): string
        {
            $live = 'f';
            if ($isLive) {
                $live = 't';
            }

            $result = $this->getDatabaseBackend()->insert(
                'INSERT INTO tracks (duration, title, youtube_id, vevo_id, isrc, is_live, is_explicit, permalink) VALUES (:duration, :title, :youtube_id, :vevo_id, :isrc, :is_live, :is_explicit, :permalink)',
                [
                    ':duration' => $duration,
                    ':title' => $title,
                    ':youtube_id' => $youtubeId,
                    ':vevo_id' => $vevoId,
                    ':isrc' => $isrc,
                    ':is_live' => $live,
                    ':is_explicit' => $isExplicit,
                    ':permalink' => $permalink
                ]
            );
            
            if (!$result) {
                throw new \Exception('Track could not be added');
            }


            return $this->getDatabaseBackend()->lastInsertId('tracks_id_seq');
        }
    }
}

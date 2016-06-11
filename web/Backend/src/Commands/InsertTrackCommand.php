<?php

namespace Jukebox\Backend\Commands
{

    use Jukebox\Framework\ValueObjects\PostgresBool;

    class InsertTrackCommand extends AbstractDatabaseBackendCommand
    {
        public function execute(
            int $duration,
            string $title,
            string $vevoId = null,
            string $isrc = null,
            PostgresBool $isLive,
            PostgresBool $isExplicit,
            string $permalink
        ): string
        {
            $result = $this->getDatabaseBackend()->insert(
                'INSERT INTO tracks (duration, title, vevo_id, isrc, is_live, is_explicit, permalink) VALUES (:duration, :title, :vevo_id, :isrc, :is_live, :is_explicit, :permalink)',
                [
                    ':duration' => $duration,
                    ':title' => $title,
                    ':vevo_id' => $vevoId,
                    ':isrc' => $isrc,
                    ':is_live' => (string) $isLive,
                    ':is_explicit' => (string) $isExplicit,
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

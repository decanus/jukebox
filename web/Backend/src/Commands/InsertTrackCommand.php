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
            PostgresBool $isLyric,
            PostgresBool $isAudio,
            PostgresBool $isMusicVideo,
            PostgresBool $isExplicit,
            string $permalink,
            \DateTime $releaseDate
        ): string
        {
            $result = $this->getDatabaseBackend()->insert(
                'INSERT INTO tracks (
                    duration,
                    title,
                    vevo_id,
                    isrc,
                    is_live,
                    is_lyric,
                    is_audio,
                    is_music_video,
                    is_explicit,
                    permalink,
                    release_date
                ) VALUES (
                    :duration,
                    :title,
                    :vevo_id,
                    :isrc,
                    :is_live,
                    :is_lyric,
                    :is_audio,
                    :is_music_video,
                    :is_explicit,
                    :permalink,
                    :release_date
                )',
                [
                    ':duration' => $duration,
                    ':title' => $title,
                    ':vevo_id' => $vevoId,
                    ':isrc' => $isrc,
                    ':is_live' => (string) $isLive,
                    ':is_lyric' => (string) $isLyric,
                    ':is_audio' => (string) $isAudio,
                    ':is_music_video' => (string) $isMusicVideo,
                    ':is_explicit' => (string) $isExplicit,
                    ':permalink' => $permalink,
                    ':release_date' => $releaseDate->format('Y-m-d')
                ]
            );
            
            if (!$result) {
                throw new \Exception('Track could not be added');
            }


            return $this->getDatabaseBackend()->lastInsertId('tracks_id_seq');
        }
    }
}

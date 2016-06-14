<?php

namespace Jukebox\Backend\Commands
{

    use Jukebox\Backend\DataObjects\Track;
    use Jukebox\Framework\ValueObjects\PostgresBool;

    class InsertTrackCommand extends AbstractDatabaseBackendCommand
    {
        public function execute(Track $track, array $sources = [], array $genres = [], array $artists = []): bool
        {
            try {

                $database = $this->getDatabaseBackend();

                // @todo: possible fix?
                while ($database->inTransaction()) {
                    sleep(1);
                }

                $database->beginTransaction();
                $result = $database->insert(
                    'INSERT INTO tracks (duration, title, vevo_id, isrc, is_live, is_lyric, is_audio, is_music_video, is_explicit, permalink, release_date) VALUES (:duration, :title, :vevo_id, :isrc, :is_live, :is_lyric, :is_audio, :is_music_video, :is_explicit, :permalink, :release_date)',
                    [
                        ':duration' => $track->getDuration(),
                        ':title' => $track->getTitle(),
                        ':vevo_id' => $track->getVevoId(),
                        ':isrc' => $track->getIsrc(),
                        ':is_live' => (string) new PostgresBool($track->isLive()),
                        ':is_lyric' => (string) new PostgresBool($track->hasLyrics()),
                        ':is_audio' => (string) new PostgresBool($track->isAudio()),
                        ':is_music_video' => (string) new PostgresBool($track->isOfficial()),
                        ':is_explicit' => (string) new PostgresBool($track->isExplicit()),
                        ':permalink' => $track->getPermalink(),
                        ':release_date' => $track->getReleaseDate()->format('Y-m-d')
                    ]
                );

                if (!$result) {
                    throw new \RuntimeException('Track insert unsuccessful');
                }

                $trackId = $database->lastInsertId('tracks_id_seq');

                foreach ($sources as $source) {
                    try {
                        $database->insert(
                            'INSERT INTO track_sources (track, duration, source, source_data) VALUES(:track, :duration, :source, :source_data)',
                            [':track' => $trackId, ':duration' => $source['duration'], ':source' => (string) $source['source'], ':source_data' => $source['sourceData']]
                        );
                    } catch (\Throwable $e) {
                        continue;
                    }
                }

                foreach ($genres as $genre) {
                    try {
                        $database->insert(
                            'INSERT INTO track_genres (track, genre) VALUES(:track, (SELECT id FROM genres WHERE name = :name))',
                            [':track' => $trackId, ':name' => $genre]
                        );
                    } catch (\Throwable $e) {
                        continue;
                    }
                }

                foreach ($artists as $artist) {
                    try {
                        $database->insert(
                            'INSERT INTO track_artists (artist, track, role) VALUES ((SELECT id FROM artists WHERE vevo_id = :artist), :track, :role)',
                            [':artist' => $artist['vevo_id'], ':track' => $trackId, ':role' => (string) $artist['role']]
                        );
                    } catch (\Throwable $e) {
                        continue;
                    }
                }

                $database->commit();
            } catch (\Throwable $e) {
                $this->getDatabaseBackend()->rollBack();
                return false;
            }

            return true;
        }
    }
}

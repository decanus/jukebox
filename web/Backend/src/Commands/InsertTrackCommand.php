<?php

namespace Jukebox\Backend\Commands
{

    use Jukebox\Backend\DataObjects\Track;
    use Jukebox\Framework\Logging\LoggerAware;
    use Jukebox\Framework\Logging\LoggerAwareTrait;
    use Jukebox\Framework\ValueObjects\PostgresBool;

    class InsertTrackCommand extends AbstractDatabaseBackendCommand implements LoggerAware
    {
        use LoggerAwareTrait;

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
                        $genre = $database->fetch('SELECT id FROM genres WHERE name = :name', [':name' => $genre]);

                        if (!$genre) {
                            continue;
                        }

                        $database->insert(
                            'INSERT INTO track_genres (track, genre) VALUES(:track, :id)',
                            [':track' => $trackId, ':name' => $genre['id']]
                        );
                    } catch (\Throwable $e) {
                        continue;
                    }
                }

                foreach ($artists as $artist) {
                    try {
                        $artistId = $database->fetch('SELECT id FROM artists WHERE vevo_id = :artist', [':artist' => $artist['vevo_id']]);
                        if (!$artistId) {
                            continue;
                        }

                        $database->insert(
                            'INSERT INTO track_artists (artist, track, role) VALUES (:artist, :track, :role)',
                            [':artist' => $artistId['id'], ':track' => $trackId, ':role' => (string) $artist['role']]
                        );
                    } catch (\Throwable $e) {
                        continue;
                    }
                }

                $result = $database->commit();
                if (!$result) {
                    throw new \Exception('Failed');
                }
            } catch (\Throwable $e) {
                $this->getLogger()->critical($e);
                $this->getDatabaseBackend()->rollBack();
                return false;
            }

            return true;
        }
    }
}

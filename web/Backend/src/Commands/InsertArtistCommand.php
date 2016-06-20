<?php

namespace Jukebox\Backend\Commands
{

    use Jukebox\Framework\Logging\LoggerAware;
    use Jukebox\Framework\Logging\LoggerAwareTrait;

    class InsertArtistCommand extends AbstractDatabaseBackendCommand implements LoggerAware
    {
        use LoggerAwareTrait;

        public function execute(string $artist, string $vevoId = null, string $permalink, string $image = null, array $webProfiles = []): bool
        {
            try {
                $database = $this->getDatabaseBackend();

                $database->beginTransaction();

                $database->insert(
                    'INSERT INTO artists (name, vevo_id, permalink, image) VALUES (:name, :vevo_id, :permalink, :image)',
                    [':name' => $artist, ':vevo_id' => $vevoId, ':permalink' => $permalink, ':image' => $image]
                );

                $artistId = $database->lastInsertId('artists_id_seq');

                foreach ($webProfiles as $webProfile) {
                    $database->insert(
                        'INSERT INTO artist_web_profiles (artist, profile, profile_data) VALUES (:artist, :profile, :profile_data)',
                        [':artist' => $artistId, ':profile' => (string) $webProfile['profile'], ':profile_data' => $webProfile['profileData']]
                    );
                }

                $database->commit();
            } catch (\Throwable $e) {
                $this->getLogger()->critical($e);
                $this->getDatabaseBackend()->rollBack();
                return false;
            }

            return true;
        }
    }
}

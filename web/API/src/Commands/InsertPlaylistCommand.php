<?php

namespace Jukebox\API\Commands
{

    use Jukebox\API\DataObjects\Playlist;
    use Jukebox\Framework\Backends\PostgreDatabaseBackend;
    use Jukebox\Framework\ValueObjects\PostgresBool;

    class InsertPlaylistCommand
    {
        /**
         * @var PostgreDatabaseBackend
         */
        private $databaseBackend;

        public function __construct(PostgreDatabaseBackend $postgreDatabaseBackend)
        {
            $this->databaseBackend = $postgreDatabaseBackend;
        }

        public function execute(Playlist $playlist): string
        {
            $this->databaseBackend->insert(
                'INSERT INTO playlists (owner, name, description, private) VALUES (:owner, :name, :description, :private)',
                [
                    ':owner' => $playlist->getOwner(),
                    ':name' => $playlist->getName(),
                    ':description' => null,
                    ':private' => (string) new PostgresBool(false)
                ]
            );

            // @todo return
            return $this->databaseBackend->lastInsertId('playlists_id_seq');
        }
    }
}

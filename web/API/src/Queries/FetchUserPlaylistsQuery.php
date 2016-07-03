<?php

namespace Jukebox\API\Queries
{

    use Jukebox\Framework\Backends\PostgreDatabaseBackend;

    class FetchUserPlaylistsQuery
    {
        /**
         * @var PostgreDatabaseBackend
         */
        private $postgreDatabaseBackend;

        public function __construct(PostgreDatabaseBackend $postgreDatabaseBackend)
        {
            $this->postgreDatabaseBackend = $postgreDatabaseBackend;
        }

        public function execute(string $userId): array
        {
            return $this->postgreDatabaseBackend->fetchAll(
                'SELECT * FROM playlists WHERE owner = :owner',
                [':owner' => $userId]
            );
        }
    }
}

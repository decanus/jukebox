<?php

namespace Jukebox\API\Queries
{

    use Jukebox\Framework\Backends\PostgreDatabaseBackend;

    class FetchUserPlaylistQuery
    {
        /**
         * @var PostgreDatabaseBackend
         */
        private $postgreDatabaseBackend;

        public function __construct(PostgreDatabaseBackend $postgreDatabaseBackend)
        {
            $this->postgreDatabaseBackend = $postgreDatabaseBackend;
        }

        /**
         * @param string $userId
         * @param string $playlistId
         * 
         * @return array|null|object
         * @throws \Throwable
         */
        public function execute(string $userId, string $playlistId)
        {
            return $this->postgreDatabaseBackend->fetch(
                'SELECT * FROM playlists WHERE owner = :owner AND id = :id',
                ['owner' => $userId, 'id' => $playlistId]
            );
        }
    }
}

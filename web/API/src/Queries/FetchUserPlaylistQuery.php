<?php

namespace Jukebox\API\Queries
{

    use Jukebox\Framework\Backends\MongoDatabaseBackend;
    use MongoDB\BSON\ObjectID;

    class FetchUserPlaylistQuery
    {
        /**
         * @var MongoDatabaseBackend
         */
        private $mongoDatabaseBackend;

        public function __construct(MongoDatabaseBackend $mongoDatabaseBackend)
        {
            $this->mongoDatabaseBackend = $mongoDatabaseBackend;
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
            return $this->mongoDatabaseBackend->findOne(
                'playlists',
                ['owner' => $userId, '_id' => new ObjectID($playlistId)]
            );
        }
    }
}

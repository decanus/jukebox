<?php

namespace Jukebox\API\Commands
{

    use Jukebox\API\DataObjects\Playlist;
    use Jukebox\Framework\Backends\MongoDatabaseBackend;
    use MongoDB\InsertOneResult;

    class InsertPlaylistCommand
    {
        /**
         * @var MongoDatabaseBackend
         */
        private $databaseBackend;

        public function __construct(MongoDatabaseBackend $databaseBackend)
        {
            $this->databaseBackend = $databaseBackend;
        }

        public function execute(Playlist $playlist): InsertOneResult
        {
            return $this->databaseBackend->insertOne('playlists', $playlist->toArray());
        }
    }
}

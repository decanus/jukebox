<?php

namespace Jukebox\API\Commands
{

    use Jukebox\API\DataObjects\Playlist;
    use Jukebox\Framework\Backends\MongoDatabaseBackend;

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

        public function execute(Playlist $playlist)
        {
            $this->databaseBackend->insertOne('playlists', $playlist->toArray());
        }
    }
}

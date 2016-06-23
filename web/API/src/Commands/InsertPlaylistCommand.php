<?php

namespace Jukebox\API\Commands
{

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

        public function execute(string $name)
        {
            $this->databaseBackend->insertOne('playlists', ['name' => $name]);
        }
    }
}

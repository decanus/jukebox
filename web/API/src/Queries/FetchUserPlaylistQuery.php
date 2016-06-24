<?php

namespace Jukebox\API\Queries
{

    use Jukebox\Framework\Backends\MongoDatabaseBackend;

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

        public function execute(string $userId, string $playlistId)
        {
            
        }
    }
}

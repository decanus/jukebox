<?php

namespace Jukebox\Backend\Commands
{

    use Jukebox\Framework\Backends\PostgreDatabaseBackend;

    class InsertArtistCommand
    {
        /**
         * @var PostgreDatabaseBackend
         */
        private $postgreDatabaseBackend;

        public function __construct(PostgreDatabaseBackend $postgreDatabaseBackend)
        {
            $this->postgreDatabaseBackend = $postgreDatabaseBackend;
        }

        public function execute($artist, $urlSafeName): bool
        {
            return $this->postgreDatabaseBackend->insert(
                'INSERT INTO artists (name, urlSafeName) VALUES (:name, :urlSafeName)',
                [':name' => $artist, ':urlSafeName' => $urlSafeName]
            );
        }
    }
}

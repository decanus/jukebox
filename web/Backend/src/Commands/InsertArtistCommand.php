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

        public function execute($artist, $urlSafeName, bool $isVevo = false): bool
        {
            return $this->postgreDatabaseBackend->insert(
                'INSERT INTO artists (name, urlSafeName, isVevo) VALUES (:name, :urlSafeName, :isVevo)',
                [':name' => $artist, ':urlSafeName' => $urlSafeName, ':isVevo' => $isVevo]
            );
        }
    }
}

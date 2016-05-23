<?php

namespace Jukebox\API\Queries
{

    use Jukebox\Framework\Backends\PostgreDatabaseBackend;

    class FetchArtistQuery
    {
        /**
         * @var PostgreDatabaseBackend
         */
        private $databaseBackend;

        public function __construct(PostgreDatabaseBackend $databaseBackend)
        {
            $this->databaseBackend = $databaseBackend;
        }

        public function execute(string $id)
        {
            return $this->databaseBackend->fetch('SELECT * FROM artists WHERE id = :id', [':id' => $id]);
        }
    }
}

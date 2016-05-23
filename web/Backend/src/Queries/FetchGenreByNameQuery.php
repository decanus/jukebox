<?php

namespace Jukebox\Backend\Queries
{

    use Jukebox\Framework\Backends\PostgreDatabaseBackend;

    class FetchGenreByNameQuery
    {
        /**
         * @var PostgreDatabaseBackend
         */
        private $databaseBackend;

        public function __construct(PostgreDatabaseBackend $databaseBackend)
        {
            $this->databaseBackend = $databaseBackend;
        }

        public function execute(string $name): mixed
        {
            return $this->databaseBackend->fetchAll('SELECT * FROM genres WHERE name = :name', [':name' => $name]);
        }
    }
}

<?php

namespace Jukebox\Backend\Queries
{
    class FetchGenreByNameQuery extends AbstractDatabaseBackendQuery
    {
        public function execute(string $name): array
        {
            return $this->getDatabaseBackend()->fetch('SELECT * FROM genres WHERE name = :name', [':name' => $name]);
        }
    }
}

<?php

namespace Jukebox\Backend\Queries
{

    use Jukebox\Framework\Backends\PostgreDatabaseBackend;

    class FetchVevoArtistsQuery
    {
        /**
         * @var PostgreDatabaseBackend
         */
        private $databaseBackend;

        public function __construct(PostgreDatabaseBackend $databaseBackend)
        {
            $this->databaseBackend = $databaseBackend;
        }

        /**
         * @return array
         */
        public function execute()
        {
            return $this->databaseBackend->fetchAll('SELECT * FROM artists WHERE vevo_id IS NOT NULL');
        }
    }
}

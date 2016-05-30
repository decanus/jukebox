<?php

namespace Jukebox\Backend\Queries
{

    use Jukebox\Framework\Backends\PostgreDatabaseBackend;

    abstract class AbstractDatabaseBackendQuery
    {
        /**
         * @var PostgreDatabaseBackend
         */
        private $databaseBackend;

        public function __construct(PostgreDatabaseBackend $databaseBackend)
        {
            $this->databaseBackend = $databaseBackend;
        }

        protected function getDatabaseBackend(): PostgreDatabaseBackend
        {
            return $this->databaseBackend;
        }
    }
}

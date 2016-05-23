<?php

namespace Jukebox\Backend\Commands
{

    use Jukebox\Framework\Backends\PostgreDatabaseBackend;

    abstract class AbstractDatabaseBackendCommand
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

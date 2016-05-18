<?php

namespace Jukebox\Backend\EventHandlers\Commands
{
    use Jukebox\Framework\Backends\PostgreDatabaseBackend;

    class InsertGenreCommand
    {
        /**
         * @var PostgreDatabaseBackend
         */
        private $databaseBackend;

        public function __construct(PostgreDatabaseBackend $databaseBackend)
        {
            $this->databaseBackend = $databaseBackend;
        }

        public function execute(string $name)
        {
            $this->databaseBackend->insert('INSERT INTO genres (name) VALUES (:name)', [
                'name' => $name
            ]);
        }
    }

}

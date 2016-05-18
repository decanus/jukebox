<?php

namespace Jukebox\Backend\EventHandlers\Commands
{
    use Jukebox\Framework\Backends\PostgresDatabaseBackend;

    class InsertGenreCommand
    {
        /**
         * @var PostgresDatabaseBackend
         */
        private $databaseBackend;

        public function __construct(PostgresDatabaseBackend $databaseBackend)
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

<?php

namespace Jukebox\Backend\Commands
{
    class InsertGenreCommand extends AbstractDatabaseBackendCommand
    {
        public function execute(string $name)
        {
            $this->getDatabaseBackend()->execute('INSERT INTO genres (name) VALUES (:name)', [
                'name' => $name
            ]);
        }
    }

}

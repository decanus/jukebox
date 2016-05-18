<?php

namespace Jukebox\Backend\Factories
{
    use Jukebox\Framework\Factories\AbstractFactory;

    class CommandFactory extends AbstractFactory
    {
        public function createInsertGenreCommand()
        {
            return new \Jukebox\Backend\Commands\InsertGenreCommand(
                $this->getMasterFactory()->createPostgreDatabaseBackend()
            );
        }
        public function createInsertVevoArtistCommand()
        {
            return new \Jukebox\Backend\Commands\InsertVevoArtistCommand(
                $this->getMasterFactory()->createPostgreDatabaseBackend()
            );
        }
    }
}



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
        public function createInsertArtistCommand()
        {
            return new \Jukebox\Backend\Commands\InsertArtistCommand(
                $this->getMasterFactory()->createPostgreDatabaseBackend()
            );
        }
    }
}



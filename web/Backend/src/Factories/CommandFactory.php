<?php

namespace Jukebox\Backend\Factories
{
    use Jukebox\Framework\Factories\AbstractFactory;

    class CommandFactory extends AbstractFactory
    {
        public function createInsertGenreCommand()
        {
            return new \Jukebox\Backend\EventHandlers\Commands\InsertGenreCommand(
                $this->getMasterFactory()->createPostgreDatabaseBackend()
            );
        }
    }
}



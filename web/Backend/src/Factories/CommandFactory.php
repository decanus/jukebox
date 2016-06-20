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

        public function createUpdateArtistSoundcloudIdCommand(): \Jukebox\Backend\Commands\UpdateArtistSoundcloudIdCommand
        {
            return new \Jukebox\Backend\Commands\UpdateArtistSoundcloudIdCommand(
                $this->getMasterFactory()->createPostgreDatabaseBackend()
            );
        }
        
        public function createInsertTrackCommand(): \Jukebox\Backend\Commands\InsertTrackCommand
        {
            return new \Jukebox\Backend\Commands\InsertTrackCommand(
                $this->getMasterFactory()->createPostgreDatabaseBackend()
            );
        }
    }
}



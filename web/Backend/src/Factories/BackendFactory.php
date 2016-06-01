<?php

namespace Jukebox\Backend\Factories
{

    class BackendFactory extends \Jukebox\Framework\Factories\BackendFactory
    {
        public function createPostgreDatabaseBackend(): \Jukebox\Backend\Backends\PostgreDatabaseBackend
        {
            return new \Jukebox\Backend\Backends\PostgreDatabaseBackend(
                new \Jukebox\Backend\Backends\PDO(
                    $this->getMasterFactory()->getConfiguration()->get('postgreServer'),
                    $this->getMasterFactory()->getConfiguration()->get('postgreUsername'),
                    $this->getMasterFactory()->getConfiguration()->get('postgrePassword')
                )
            );
        }
    }
}

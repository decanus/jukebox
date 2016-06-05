<?php

namespace Jukebox\API\Factories
{

    use Jukebox\Framework\Factories\AbstractFactory;

    class CommandFactory extends AbstractFactory
    {
        public function createAuthenticationCommand(): \Jukebox\API\Commands\AuthenticationCommand
        {
            return new \Jukebox\API\Commands\AuthenticationCommand(
                $this->getMasterFactory()->createMongoDatabaseBackend()
            );
        }
        
        public function createRegistrationCommand(): \Jukebox\API\Commands\RegistrationCommand
        {
            return new \Jukebox\API\Commands\RegistrationCommand(
                $this->getMasterFactory()->createMongoDatabaseBackend()
            );
        }
    }
}

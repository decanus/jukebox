<?php

namespace Jukebox\API\Factories
{

    use Jukebox\API\Session\SessionData;
    use Jukebox\Framework\Factories\AbstractFactory;

    class CommandFactory extends AbstractFactory
    {
        /**
         * @var SessionData
         */
        private $sessionData;

        public function __construct(SessionData $sessionData)
        {
            $this->sessionData = $sessionData;
        }

        public function createAuthenticationCommand(): \Jukebox\API\Commands\AuthenticationCommand
        {
            return new \Jukebox\API\Commands\AuthenticationCommand(
                $this->getMasterFactory()->createMongoDatabaseBackend(),
                $this->sessionData
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

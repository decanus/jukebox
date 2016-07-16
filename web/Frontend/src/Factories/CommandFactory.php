<?php

namespace Jukebox\Frontend\Factories
{

    use Jukebox\Framework\Factories\AbstractFactory;
    use Jukebox\Frontend\Session\Session;

    class CommandFactory extends AbstractFactory
    {
        /**
         * @var Session
         */
        private $session;

        public function __construct(Session $session)
        {
            $this->session = $session;
        }

        public function createLoginCommand(): \Jukebox\Frontend\Commands\LoginCommand
        {
            return new \Jukebox\Frontend\Commands\LoginCommand(
                $this->getMasterFactory()->createJukeboxRestManager(),
                $this->session->getSessionData()
            );
        }

        public function createRegistrationCommand(): \Jukebox\Frontend\Commands\RegistrationCommand
        {
            return new \Jukebox\Frontend\Commands\RegistrationCommand(
                $this->getMasterFactory()->createJukeboxRestManager()
            );
        }
    }
}

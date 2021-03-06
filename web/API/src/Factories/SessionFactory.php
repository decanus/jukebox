<?php

namespace Jukebox\API\Factories
{

    use Jukebox\API\Session\Session;
    use Jukebox\API\Session\SessionDataFactory;
    use Jukebox\API\Session\SessionStore;
    use Jukebox\Framework\Factories\AbstractFactory;

    class SessionFactory extends AbstractFactory
    {
        /**
         * @var Session
         */
        private $session;

        /**
         * @var SessionStore
         */
        private $sessionStore;

        public function __construct(SessionStore $sessionStore)
        {
            $this->sessionStore = $sessionStore;
        }

        public function createSession(): Session
        {
            if ($this->session === null) {
                $this->session = new Session($this->sessionStore, $this->createSessionDataFactory());
            }

            return $this->session;
        }

        public function createSessionDataFactory(): SessionDataFactory
        {
            return new SessionDataFactory;
        }
    }
}

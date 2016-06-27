<?php

namespace Jukebox\Frontend\Factories
{

    use Jukebox\Frontend\Session\Session;
    use Jukebox\Frontend\Session\SessionDataFactory;
    use Jukebox\Frontend\Session\SessionStore;
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

        /**
         * @var bool
         */
        private $isDevelopmentMode;

        public function __construct(SessionStore $sessionStore, $isDevelopmentMode = false)
        {
            $this->sessionStore = $sessionStore;
            $this->isDevelopmentMode = $isDevelopmentMode;
        }

        public function createSession(): Session
        {
            if ($this->session === null) {
                $this->session = new Session(
                    $this->sessionStore,
                    $this->createSessionDataFactory(),
                    $this->isDevelopmentMode
                );
            }

            return $this->session;
        }

        public function createSessionDataFactory(): SessionDataFactory
        {
            return new SessionDataFactory;
        }
    }
}

<?php

namespace Jukebox\Frontend\Commands
{

    use Jukebox\Frontend\Session\SessionStore;

    class DeleteSessionCommand
    {
        /**
         * @var SessionStore
         */
        private $sessionStore;

        public function __construct(SessionStore $sessionStore)
        {
            $this->sessionStore = $sessionStore;
        }

        public function execute(string $id)
        {
            $this->sessionStore->remove($id);
        }
    }
}

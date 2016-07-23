<?php

namespace Jukebox\Frontend\Session
{

    use Jukebox\Framework\Session\AbstractSessionStore;

    class SessionStore extends AbstractSessionStore
    {

        protected function generateSessionKey($id): string
        {
            return 'session_' . $id;
        }
    }
}

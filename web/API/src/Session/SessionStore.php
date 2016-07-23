<?php

namespace Jukebox\API\Session
{

    use Jukebox\Framework\Session\AbstractSessionStore;

    class SessionStore extends AbstractSessionStore
    {
        protected function generateSessionKey($id): string 
        {
            return 'api_session_' . $id;
        }
    }
}

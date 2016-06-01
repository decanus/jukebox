<?php

namespace Jukebox\API\Session
{
    class SessionDataFactory
    {
        public function createSessionData(Map $map): SessionData
        {
            return new SessionData($map);
        }
    }
}

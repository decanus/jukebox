<?php

namespace Jukebox\API\Session
{

    use Jukebox\Framework\Session\AbstractSessionData;
    use Jukebox\Framework\Session\Map;

    class SessionDataFactory implements \Jukebox\Framework\Session\SessionDataFactory
    {
        public function createSessionData(Map $map): AbstractSessionData
        {
            return new SessionData($map);
        }
    }
}

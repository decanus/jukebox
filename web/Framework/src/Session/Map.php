<?php

namespace Jukebox\Framework\Session
{

    use Jukebox\Framework\ValueObjects\Token;

    class Map extends \Jukebox\Framework\Map
    {
        private $sessionId;

        public function setSessionId(Token $sessionId)
        {
            $this->sessionId = $sessionId;
        }

        public function getSessionId(): Token
        {
            return $this->sessionId;
        }
    }
}

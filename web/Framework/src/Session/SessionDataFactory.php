<?php


namespace Jukebox\Framework\Session
{
    interface SessionDataFactory
    {
        public function createSessionData(Map $map): AbstractSessionData;
    }
}

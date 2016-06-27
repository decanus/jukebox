<?php

namespace Jukebox\Frontend\Session
{

    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\Session\AbstractSession;
    use Jukebox\Framework\Session\AbstractSessionData;
    use Jukebox\Framework\ValueObjects\Cookie;

    class Session extends AbstractSession
    {

        public function load(RequestInterface $request): AbstractSessionData
        {
            // TODO: Implement load() method.
        }

        public function getCookie(): Cookie
        {
            return new Cookie(
                'SID',
                (string) $this->getSecureId(),
                $this->getExpire()
            );
        }
    }
}

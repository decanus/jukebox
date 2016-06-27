<?php

namespace Jukebox\Frontend\Session
{

    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\Session\AbstractSession;
    use Jukebox\Framework\Session\AbstractSessionData;
    use Jukebox\Framework\ValueObjects\Cookie;
    use Jukebox\Framework\ValueObjects\SessionToken;

    class Session extends AbstractSession
    {
        private $isSessionStarted = false;

        public function load(RequestInterface $request): AbstractSessionData
        {
            $this->setId($request);
            $this->setSessionData($this->loadSessionData());

            return $this->getSessionData();
        }

        public function isSessionStarted(): bool
        {
            return $this->isSessionStarted;
        }

        public function getCookie(): Cookie
        {
            return new Cookie(
                'SID',
                (string) $this->getSecureId(),
                '/',
                time() + $this->getExpire(),
                '.jukebox.ninja',
                false,
                true
            );
        }

        private function setId(RequestInterface $request)
        {
            if ($request->hasCookieParameter('SID')) {
                $this->setSecureId(new SessionToken($request->getCookieParameter('SID')));
                $this->isSessionStarted = true;
                return;
            }

            $this->setSecureId(new SessionToken);
        }
    }
}

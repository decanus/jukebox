<?php

namespace Jukebox\Frontend\Session
{

    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\Session\AbstractSession;
    use Jukebox\Framework\Session\AbstractSessionData;
    use Jukebox\Framework\Session\SessionStoreInterface;
    use Jukebox\Framework\ValueObjects\Cookie;
    use Jukebox\Framework\ValueObjects\SessionToken;

    class Session extends AbstractSession
    {
        private $isSessionStarted = false;
        /**
         * @var bool
         */
        private $isDevelopment;

        public function __construct(
            SessionStoreInterface $sessionStore,
            SessionDataFactory $sessionDataFactory,
            bool $isDevelopment = false
        )
        {
            parent::__construct($sessionStore, $sessionDataFactory);
            $this->isDevelopment = $isDevelopment;
        }

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
                !$this->isDevelopment
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

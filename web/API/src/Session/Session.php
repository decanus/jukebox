<?php

namespace Jukebox\API\Session
{

    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\Session\AbstractSession;
    use Jukebox\Framework\Session\AbstractSessionData;
    use Jukebox\Framework\ValueObjects\AccessToken;

    class Session extends AbstractSession
    {
        /**
         * @var AccessToken
         */
        private $secureId;

        public function load(RequestInterface $request): AbstractSessionData
        {
            $this->secureId = null;

            if ($request->hasParameter('access_token')) {
                $this->secureId = new AccessToken($request->getParameter('access_token'));
            }

            $this->setSessionData($this->loadSessionData());

            if ($this->getSessionData()->isEmpty()) {
                $this->secureId = new AccessToken;
                $this->getSessionData()->getMap()->setSessionId($this->secureId);
            }

            return $this->getSessionData();
        }
    }
}

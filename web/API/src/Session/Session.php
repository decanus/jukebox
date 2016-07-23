<?php

namespace Jukebox\API\Session
{

    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\Session\AbstractSession;
    use Jukebox\Framework\Session\AbstractSessionData;
    use Jukebox\Framework\ValueObjects\AccessToken;

    class Session extends AbstractSession
    {

        public function load(RequestInterface $request): AbstractSessionData
        {
            if ($request->hasParameter('access_token')) {
                $this->setSecureId(new AccessToken($request->getParameter('access_token')));
            }

            $this->setSessionData($this->loadSessionData());

            if ($this->getSessionData()->isEmpty()) {
                $this->setSecureId(new AccessToken);
                $this->getSessionData()->getMap()->setSessionId($this->getSecureId());
            }

            return $this->getSessionData();
        }
    }
}

<?php

namespace Jukebox\API\Session
{

    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\Session\AbstractSession;
    use Jukebox\Framework\Session\AbstractSessionData;
    use Jukebox\Framework\ValueObjects\AccessToken;
    use Jukebox\Framework\ValueObjects\RefreshToken;

    class Session extends AbstractSession
    {
        public function load(RequestInterface $request): AbstractSessionData
        {

            $this->setSessionData($this->loadSessionData());

            if ($this->getSessionData()->isEmpty()) {
                $this->setSecureId(new AccessToken);
                $this->getSessionData()->getMap()->setRefreshToken(new RefreshToken);
                $this->getSessionData()->getMap()->setSessionId($this->getSecureId());
            }

            return $this->getSessionData();
        }
    }
}

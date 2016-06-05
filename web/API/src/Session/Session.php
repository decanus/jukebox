<?php

namespace Jukebox\API\Session
{

    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\ValueObjects\AccessToken;

    class Session
    {
        /**
         * @var SessionData
         */
        private $data;

        private $expireInSeconds = 2592000; // 1 month

        /**
         * @var AccessToken
         */
        private $secureId;

        /**
         * @var SessionStoreInterface
         */
        private $sessionStore;

        /**
         * @var SessionDataFactory
         */
        private $sessionDataFactory;

        public function __construct(
            SessionStoreInterface $sessionStore,
            SessionDataFactory $sessionDataFactory
        )
        {
            $this->sessionStore = $sessionStore;
            $this->sessionDataFactory = $sessionDataFactory;
        }

        public function load(RequestInterface $request): SessionData
        {
            $this->secureId = null;

            if ($request->hasParameter('access_token')) {
                $this->secureId = new AccessToken($request->getParameter('access_token'));
            }

            $this->data = $this->loadSessionData();

            if ($this->data->isEmpty()) {
                $this->secureId = new AccessToken;
                $this->data->getMap()->setSessionId($this->secureId);
            }

            return $this->data;
        }

        public function getSessionData(): SessionData
        {
            return $this->data;
        }

        public function loadSessionData(): SessionData
        {
            return $this->sessionDataFactory->createSessionData($this->loadMap($this->secureId));
        }

        public function commit()
        {
            $this->sessionStore->save((string) $this->secureId, $this->data->getMap());
            $this->sessionStore->expire((string) $this->secureId, $this->expireInSeconds);
        }

        private function loadMap($id)
        {
            if ($id === null) {
                return new Map();
            }

            return $this->sessionStore->loadById($id);
        }
    }
}

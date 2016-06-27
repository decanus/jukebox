<?php

namespace Jukebox\Framework\Session
{

    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\ValueObjects\Token;

    abstract class AbstractSession
    {
        /**
         * @var AbstractSessionData
         */
        private $data;

        private $expireInSeconds = 2592000; // 1 month

        /**
         * @var Token
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

        abstract public function load(RequestInterface $request): AbstractSessionData;

        protected function setSessionData(AbstractSessionData $data)
        {
            $this->data = $data;
        }

        public function getSessionData(): AbstractSessionData
        {
            return $this->data;
        }

        public function loadSessionData(): AbstractSessionData
        {
            return $this->sessionDataFactory->createSessionData($this->loadMap($this->getSecureId()));
        }

        public function commit()
        {
            $this->sessionStore->save((string) $this->getSecureId(), $this->data->getMap());
            $this->sessionStore->expire((string) $this->getSecureId(), $this->expireInSeconds);
        }

        private function loadMap($id): Map
        {
            if ($id === null) {
                return new Map;
            }

            return $this->sessionStore->loadById($id);
        }

        protected function setSecureId(Token $token)
        {
            $this->secureId = $token;
        }

        protected function getSecureId(): Token
        {
            return $this->secureId;
        }
    }
}

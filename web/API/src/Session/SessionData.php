<?php

namespace Jukebox\API\Session
{

    use Jukebox\API\DataObjects\Accounts\AccountInterface;
    use Jukebox\API\DataObjects\Accounts\AnonymousAccount;

    class SessionData
    {

        private $map;
        
        public function __construct(Map $map)
        {
            $this->map = $map;
        }
        
        public function isEmpty(): bool
        {
            return $this->map->isEmpty();
        }
        
        public function getAccount(): AccountInterface
        {
            if ($this->map->has('account')) {
                return unserialize($this->getMap()->get('account'));
            }

            return new AnonymousAccount;
        }
        
        public function setAccount(AccountInterface $account)
        {
            $this->map->set('account', serialize($account));
        }
        
        public function getMap(): Map
        {
            return $this->map;
        }
    }
}

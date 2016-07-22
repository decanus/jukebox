<?php

namespace Jukebox\API\Session
{

    use Jukebox\API\DataObjects\Accounts\AccountInterface;
    use Jukebox\API\DataObjects\Accounts\AnonymousAccount;
    use Jukebox\Framework\Session\AbstractSessionData;

    class SessionData extends AbstractSessionData
    {
        public function getAccount(): AccountInterface
        {
            if ($this->getMap()->has('account')) {
                return unserialize($this->getMap()->get('account'));
            }

            return new AnonymousAccount;
        }
        
        public function setAccount(AccountInterface $account)
        {
            $this->getMap()->set('account', serialize($account));
        }
    }
}

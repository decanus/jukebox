<?php

namespace Jukebox\Frontend\Session
{

    use Jukebox\Framework\Session\AbstractSessionData;
    use Jukebox\Framework\ValueObjects\AccessToken;
    use Jukebox\Frontend\DataObjects\Accounts\AccountInterface;
    use Jukebox\Frontend\DataObjects\Accounts\AnonymousAccount;

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

        public function setAccessToken(AccessToken $accessToken)
        {
            $this->getMap()->set('access_token', (string) $accessToken);
        }

        public function getAccessToken(): AccessToken
        {
            return new AccessToken($this->getMap()->get('access_token'));
        }

    }
}

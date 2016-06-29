<?php

namespace Jukebox\Frontend\Session
{

    use Jukebox\Framework\Session\AbstractSessionData;
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

    }
}

<?php

namespace Jukebox\API\Commands
{

    use Jukebox\API\DataObjects\Accounts\RegisteredAccount;
    use Jukebox\API\Session\SessionData;
    use Jukebox\API\ValueObjects\Hash;
    use Jukebox\API\ValueObjects\Salt;
    use Jukebox\Framework\Backends\MongoDatabaseBackend;
    use Jukebox\Framework\ValueObjects\Email;
    use Jukebox\Framework\ValueObjects\Password;
    use Jukebox\Framework\ValueObjects\Token;

    class AuthenticationCommand
    {
        /**
         * @var MongoDatabaseBackend
         */
        private $mongoDatabaseBackend;

        /**
         * @var SessionData
         */
        private $sessionData;

        public function __construct(
            MongoDatabaseBackend $mongoDatabaseBackend,
            SessionData $sessionData
        )
        {
            $this->mongoDatabaseBackend = $mongoDatabaseBackend;
            $this->sessionData = $sessionData;
        }

        public function execute(Email $email, Password $password): Token
        {
            $user = $this->mongoDatabaseBackend->findOne('users', ['email' => (string) $email]);

            if ($user === null) {
                return false;
            }

            $salt = new Salt($user['salt']);
            $hash = new Hash((string) $password, $salt);

            if ((string) $hash !== $user['hash']) {
                throw new \Exception('Invalid login data');
            }

            $this->sessionData->setAccount(new RegisteredAccount((string) $user['_id']));

            return $this->sessionData->getMap()->getSessionId();
        }
    }
}

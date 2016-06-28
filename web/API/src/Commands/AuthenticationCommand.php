<?php

namespace Jukebox\API\Commands
{

    use Jukebox\API\DataObjects\Accounts\RegisteredAccount;
    use Jukebox\API\Session\SessionData;
    use Jukebox\API\ValueObjects\Hash;
    use Jukebox\API\ValueObjects\Salt;
    use Jukebox\Framework\Backends\PostgreDatabaseBackend;
    use Jukebox\Framework\ValueObjects\Email;
    use Jukebox\Framework\ValueObjects\Password;
    use Jukebox\Framework\ValueObjects\Token;
    use Jukebox\Framework\ValueObjects\Username;

    class AuthenticationCommand
    {
        /**
         * @var PostgreDatabaseBackend
         */
        private $postgreDatabaseBackend;

        /**
         * @var SessionData
         */
        private $sessionData;

        public function __construct(
            PostgreDatabaseBackend $postgreDatabaseBackend,
            SessionData $sessionData
        )
        {
            $this->postgreDatabaseBackend = $postgreDatabaseBackend;
            $this->sessionData = $sessionData;
        }

        public function execute(Email $email, Password $password): Token
        {
            $user = $this->postgreDatabaseBackend->fetch(
                'SELECT * FROM users WHERE email = :email',
                ['email' => (string) $email]
            );

            if ($user === null) {
                return false;
            }

            $salt = new Salt($user['salt']);
            $hash = new Hash((string) $password, $salt);

            if ((string) $hash !== $user['hash']) {
                throw new \Exception('Invalid login data');
            }

            $this->sessionData->setAccount(
                new RegisteredAccount((string) $user['_id'], new Username($user['username']))
            );

            return $this->sessionData->getMap()->getSessionId();
        }
    }
}

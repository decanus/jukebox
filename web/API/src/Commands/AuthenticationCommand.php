<?php

namespace Jukebox\API\Commands
{

    use Jukebox\API\ValueObjects\Hash;
    use Jukebox\API\ValueObjects\Salt;
    use Jukebox\Framework\Backends\MongoDatabaseBackend;
    use Jukebox\Framework\ValueObjects\Email;
    use Jukebox\Framework\ValueObjects\Password;

    class AuthenticationCommand
    {
        /**
         * @var MongoDatabaseBackend
         */
        private $mongoDatabaseBackend;

        public function __construct(MongoDatabaseBackend $mongoDatabaseBackend)
        {
            $this->mongoDatabaseBackend = $mongoDatabaseBackend;
        }

        public function execute(Email $email, Password $password): bool
        {
            try {
                $user = $this->mongoDatabaseBackend->findOne('users', ['email' => (string)$email]);
                
                if ($user === null) {
                    return false;
                }
                
                $salt = new Salt($user['salt']);
                $hash = new Hash((string) $password, $salt);
                
                return (string) $hash === $user['hash'];
                
            } catch (\Throwable $e) {
                return false;
            }
        }
    }
}

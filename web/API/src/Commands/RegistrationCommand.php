<?php

namespace Jukebox\API\Commands
{

    use Jukebox\API\ValueObjects\Hash;
    use Jukebox\API\ValueObjects\Salt;
    use Jukebox\Framework\Backends\PostgreDatabaseBackend;
    use Jukebox\Framework\ValueObjects\Email;
    use Jukebox\Framework\ValueObjects\Username;

    class RegistrationCommand
    {
        private $postgreDatabaseBackend;

        public function __construct(PostgreDatabaseBackend $postgreDatabaseBackend)
        {
            $this->postgreDatabaseBackend = $postgreDatabaseBackend;
        }

        public function execute(Email $email, Username $username, Salt $salt, Hash $hash)
        {
            $this->postgreDatabaseBackend->insert(
                'INSERT INTO users (username, email, hash, salt) VALUES (:username, :email, :hash, :salt)',
                [
                    ':email' => (string) $email,
                    ':username' => (string) $username,
                    ':salt' => (string) $salt,
                    ':hash' => (string) $hash
                ]
            );
        }
    }
}

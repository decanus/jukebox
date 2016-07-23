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
            $this->postgreDatabaseBackend->beginTransaction();

            try {
                $this->postgreDatabaseBackend->insert(
                    'INSERT INTO users (username, email, provider) VALUES (:username, :email, "jukebox")',
                    [':email' => (string) $email, ':username' => (string) $username]
                );

                $id = $this->postgreDatabaseBackend->lastInsertId('users_id_seq');

                $this->postgreDatabaseBackend->insert(
                    'INSERT INTO user_credentials (account, salt, hash) VALUES (:account, :salt, :hash)',
                    [':account' => $id, ':salt' => (string) $salt, ':hash' => (string) $hash]
                );

            } catch (\Throwable $e) {
                $this->postgreDatabaseBackend->rollBack();
            }
        }
    }
}

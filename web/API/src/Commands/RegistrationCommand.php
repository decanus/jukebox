<?php

namespace Jukebox\API\Commands
{

    use Jukebox\API\ValueObjects\Hash;
    use Jukebox\API\ValueObjects\Salt;
    use Jukebox\Framework\Backends\MongoDatabaseBackend;
    use Jukebox\Framework\ValueObjects\Email;

    class RegistrationCommand
    {
        private $mongoDatabaseBackend;

        public function __construct(MongoDatabaseBackend $mongoDatabaseBackend)
        {
            $this->mongoDatabaseBackend = $mongoDatabaseBackend;
        }

        public function execute(Email $email, Salt $salt, Hash $hash)
        {
            $this->mongoDatabaseBackend->insertOne(
                'users',
                [
                    'email' => (string) $email,
                    'salt' => (string) $salt,
                    'hash' => (string) $hash
                ]
            );
        }
    }
}

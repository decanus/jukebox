<?php

namespace Jukebox\API\Queries
{

    use Jukebox\Framework\Backends\PostgreDatabaseBackend;
    use Jukebox\Framework\ValueObjects\Email;

    class FetchUserByEmailQuery
    {
        /**
         * @var PostgreDatabaseBackend
         */
        private $postgreDatabaseBackend;

        public function __construct(PostgreDatabaseBackend $postgreDatabaseBackend)
        {
            $this->postgreDatabaseBackend = $postgreDatabaseBackend;
        }

        /**
         * @param Email $email
         *
         * @return array|null|object
         * @throws \Throwable
         */
        public function execute(Email $email)
        {
            return $this->postgreDatabaseBackend->fetch('SELECT * FROM users WHERE email = :email', [':email' => (string) $email]);
        }
    }
}

<?php

namespace Jukebox\API\Queries
{

    use Jukebox\Framework\Backends\PostgreDatabaseBackend;

    class FetchPublicUserQuery
    {
        /**
         * @var PostgreDatabaseBackend
         */
        private $postgreDatabaseBackend;

        public function __construct(PostgreDatabaseBackend $postgreDatabaseBackend)
        {
            $this->postgreDatabaseBackend = $postgreDatabaseBackend;
        }

        public function execute(string $userId): array
        {
            return $this->postgreDatabaseBackend->fetch('SELECT username FROM users WHERE id = :id', ['id' => $userId]);
        }
    }
}

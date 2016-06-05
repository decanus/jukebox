<?php

namespace Jukebox\API\Queries
{

    use Jukebox\Framework\Backends\MongoDatabaseBackend;
    use Jukebox\Framework\ValueObjects\Email;

    class FetchUserByEmailQuery
    {
        /**
         * @var MongoDatabaseBackend
         */
        private $mongoDatabaseBackend;

        public function __construct(MongoDatabaseBackend $mongoDatabaseBackend)
        {
            $this->mongoDatabaseBackend = $mongoDatabaseBackend;
        }

        /**
         * @param Email $email
         *
         * @return array|null|object
         * @throws \Throwable
         */
        public function execute(Email $email)
        {
            return $this->mongoDatabaseBackend->findOne('users', ['email' => (string) $email]);
        }
    }
}

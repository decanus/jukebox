<?php

namespace Jukebox\API\Queries
{

    use Jukebox\Framework\Backends\MongoDatabaseBackend;
    use MongoDB\BSON\ObjectID;

    class FetchPublicUserQuery
    {
        /**
         * @var MongoDatabaseBackend
         */
        private $mongoDatabaseBackend;

        public function __construct(MongoDatabaseBackend $mongoDatabaseBackend)
        {
            $this->mongoDatabaseBackend = $mongoDatabaseBackend;
        }

        public function execute(string $userId): array
        {
            // @todo public should only have username
            $user = (array) $this->mongoDatabaseBackend->findOne(
                'users',
                ['_id' => new ObjectID($userId)],
                ['projection' => ['email' => 1]]
            );

            if ($user === null) {
                throw new \InvalidArgumentException('User "' . $userId . '" not found');
            }

            $id = $user['_id'];
            unset($user['_id']);
            $user['id'] = (string) $id;

            return $user;
        }
    }
}

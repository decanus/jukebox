<?php

namespace Jukebox\API\Handlers\Get\Me
{

    use Jukebox\API\Session\SessionData;
    use Jukebox\Framework\Backends\MongoDatabaseBackend;
    use Jukebox\Framework\Handlers\QueryHandlerInterface;
    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\Models\AbstractModel;
    use MongoDB\BSON\ObjectID;

    class QueryHandler implements QueryHandlerInterface
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

        public function execute(RequestInterface $request, AbstractModel $model)
        {
            $user = (array) $this->mongoDatabaseBackend->findOne(
                'users',
                ['_id' => new ObjectID($this->sessionData->getAccount()->getId())],
                ['projection' => ['email' => 1]]
            );

            $id = $user['_id'];
            unset($user['_id']);
            $user['id'] = (string) $id;

            $model->setData($user);
        }
    }
}

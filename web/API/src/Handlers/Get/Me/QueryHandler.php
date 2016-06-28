<?php

namespace Jukebox\API\Handlers\Get\Me
{

    use Jukebox\API\Session\SessionData;
    use Jukebox\Framework\Backends\PostgreDatabaseBackend;
    use Jukebox\Framework\Handlers\QueryHandlerInterface;
    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\Models\AbstractModel;

    class QueryHandler implements QueryHandlerInterface
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

        public function execute(RequestInterface $request, AbstractModel $model)
        {
            $user = (array) $this->postgreDatabaseBackend->fetch(
                'SELECT email, username FROM users WHERE id = :id',
                [':id' => $this->sessionData->getAccount()->getId()]
            );
            
            $model->setData($user);
        }
    }
}

<?php

namespace Jukebox\API\Handlers
{

    use Jukebox\API\DataObjects\Accounts\AnonymousAccount;
    use Jukebox\API\Session\Session;
    use Jukebox\Framework\Handlers\PostHandlerInterface;
    use Jukebox\Framework\Models\AbstractModel;

    class PostHandler implements PostHandlerInterface
    {
        /**
         * @var Session
         */
        private $session;

        public function __construct(Session $session)
        {
            $this->session = $session;
        }


        public function execute(AbstractModel $model)
        {
            if ($this->session->getSessionData()->getAccount() instanceof AnonymousAccount) {
                return;
            }
            
            $this->session->commit();
        }
    }
}

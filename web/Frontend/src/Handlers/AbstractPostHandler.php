<?php

namespace Jukebox\Frontend\Handlers
{

    use Jukebox\Framework\Handlers\PostHandlerInterface;
    use Jukebox\Framework\Models\AbstractModel;
    use Jukebox\Frontend\DataObjects\Accounts\AnonymousAccount;
    use Jukebox\Frontend\Session\Session;

    abstract class AbstractPostHandler implements PostHandlerInterface
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

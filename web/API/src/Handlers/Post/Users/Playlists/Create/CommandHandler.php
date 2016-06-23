<?php

namespace Jukebox\API\Handlers\Post\Users\Playlists\Create
{

    use Jukebox\API\Commands\InsertPlaylistCommand;
    use Jukebox\API\DataObjects\Accounts\RegisteredAccount;
    use Jukebox\API\DataObjects\Playlist;
    use Jukebox\API\Session\SessionData;
    use Jukebox\Framework\Handlers\CommandHandlerInterface;
    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\Models\AbstractModel;

    class CommandHandler implements CommandHandlerInterface
    {
        /**
         * @var InsertPlaylistCommand
         */
        private $insertPlaylistCommand;

        /**
         * @var SessionData
         */
        private $sessionData;

        public function __construct(
            InsertPlaylistCommand $insertPlaylistCommand,
            SessionData $sessionData
        )
        {
            $this->insertPlaylistCommand = $insertPlaylistCommand;
            $this->sessionData = $sessionData;
        }

        public function execute(RequestInterface $request, AbstractModel $model)
        {
            $account = $this->sessionData->getAccount();

            if (!$account instanceof RegisteredAccount) {
                // @todo set error
            }

            $this->insertPlaylistCommand->execute(
                new Playlist($request->getParameter('name'), $account->getId())
            );
        }
    }
}

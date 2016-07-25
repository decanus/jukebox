<?php

namespace Jukebox\API\Handlers\Post\Users\Playlists\Create
{

    use Jukebox\API\Commands\InsertPlaylistCommand;
    use Jukebox\API\DataObjects\Accounts\RegisteredAccount;
    use Jukebox\API\DataObjects\Playlist;
    use Jukebox\API\Session\SessionData;
    use Jukebox\Framework\Handlers\CommandHandlerInterface;
    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\Http\StatusCodes\Created;
    use Jukebox\Framework\Http\StatusCodes\Forbidden;
    use Jukebox\Framework\Http\StatusCodes\Unauthorized;
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
                $model->setData(['errors' => ['message' => 'Unauthorized']]);
                $model->setStatusCode(new Unauthorized);
                return;
            }

            if ($account->getId() !== $request->getUri()->getExplodedPath()[2]) {
                $model->setData(['errors' => ['message' => 'Forbidden']]);
                $model->setStatusCode(new Forbidden);
                return;
            }

            $return = $this->insertPlaylistCommand->execute(
                new Playlist($request->getParameter('name'), $account->getId())
            );

            // @todo return playlist object
            $model->setData(['id' => (string) $return]);
            $model->setStatusCode(new Created);
        }
    }
}

<?php

namespace Jukebox\API\Handlers\Post\Users\Playlists\Create
{

    use Jukebox\API\Commands\InsertPlaylistCommand;
    use Jukebox\Framework\Handlers\CommandHandlerInterface;
    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\Models\AbstractModel;

    class CommandHandler implements CommandHandlerInterface
    {
        /**
         * @var InsertPlaylistCommand
         */
        private $insertPlaylistCommand;

        public function __construct(InsertPlaylistCommand $insertPlaylistCommand)
        {
            $this->insertPlaylistCommand = $insertPlaylistCommand;
        }

        public function execute(RequestInterface $request, AbstractModel $model)
        {
            $this->insertPlaylistCommand->execute($request->getParameter('name'));
        }
    }
}

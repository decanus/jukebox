<?php

namespace Jukebox\Frontend\Handlers\Post\Logout
{

    use Jukebox\Framework\Handlers\CommandHandlerInterface;
    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\Models\AbstractModel;
    use Jukebox\Frontend\Commands\DeleteSessionCommand;

    class CommandHandler implements CommandHandlerInterface
    {
        /**
         * @var DeleteSessionCommand
         */
        private $deleteSessionCommand;

        public function __construct(DeleteSessionCommand $deleteSessionCommand)
        {
            $this->deleteSessionCommand = $deleteSessionCommand;
        }

        public function execute(RequestInterface $request, AbstractModel $model)
        {
            $this->deleteSessionCommand->execute($request->getCookieParameter('SID'));
        }
    }
}

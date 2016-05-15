<?php

namespace Jukebox\API\Handlers
{

    use Jukebox\Framework\Handlers\CommandHandlerInterface;
    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\Models\AbstractModel;

    class CommandHandler implements CommandHandlerInterface
    {

        public function execute(RequestInterface $request, AbstractModel $model)
        {
            // TODO: Implement execute() method.
        }
    }
}

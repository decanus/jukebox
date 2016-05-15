<?php

namespace Jukebox\API\Handlers\Get\Index
{

    use Jukebox\Framework\Handlers\TransformationHandlerInterface;
    use Jukebox\Framework\Models\AbstractModel;

    class TransformationHandler implements TransformationHandlerInterface
    {

        public function execute(AbstractModel $model): string
        {
            return json_encode(['Welcome to the Jukebox Ninja API']);
        }
    }
}

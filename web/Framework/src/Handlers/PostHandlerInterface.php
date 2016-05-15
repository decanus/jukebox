<?php


namespace Jukebox\Framework\Handlers
{

    use Jukebox\Framework\Models\AbstractModel;

    interface PostHandlerInterface
    {
        public function execute(AbstractModel $model);
    }
}

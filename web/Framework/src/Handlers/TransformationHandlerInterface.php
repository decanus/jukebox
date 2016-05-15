<?php

namespace Jukebox\Framework\Handlers
{

    use Jukebox\Framework\Models\AbstractModel;

    interface TransformationHandlerInterface
    {
        public function execute(AbstractModel $model): string;
    }
}

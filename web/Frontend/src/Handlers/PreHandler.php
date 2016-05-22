<?php

namespace Jukebox\Frontend\Handlers
{

    use Jukebox\Framework\Handlers\PreHandlerInterface;
    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\Models\AbstractModel;

    class PreHandler implements PreHandlerInterface
    {

        public function execute(RequestInterface $request, AbstractModel $model)
        {
            // TODO: Implement execute() method.
        }
    }
}

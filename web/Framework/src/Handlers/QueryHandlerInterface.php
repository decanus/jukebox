<?php


namespace Jukebox\Framework\Handlers
{

    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\Models\AbstractModel;

    interface QueryHandlerInterface
    {
        public function execute(RequestInterface $request, AbstractModel $model);
    }
}

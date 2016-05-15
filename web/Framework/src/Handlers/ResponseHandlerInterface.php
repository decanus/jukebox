<?php

namespace Jukebox\Framework\Handlers
{

    use Jukebox\Framework\Http\Response\ResponseInterface;
    use Jukebox\Framework\Models\AbstractModel;

    interface ResponseHandlerInterface
    {
        public function execute(ResponseInterface $response, AbstractModel $model);
    }
}

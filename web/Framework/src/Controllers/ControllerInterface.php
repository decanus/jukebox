<?php

namespace Jukebox\Framework\Controllers
{

    use Jukebox\Framework\Http\Request\AbstractRequest;
    use Jukebox\Framework\Http\Response\AbstractResponse;

    interface ControllerInterface
    {
        public function execute(AbstractRequest $request): AbstractResponse;
    }
}

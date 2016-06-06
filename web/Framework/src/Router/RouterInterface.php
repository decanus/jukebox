<?php


namespace Jukebox\Framework\Routers
{

    use Jukebox\Framework\Controllers\ControllerInterface;
    use Jukebox\Framework\Http\Request\RequestInterface;

    interface RouterInterface
    {
        public function route(RequestInterface $request): ControllerInterface;
    }
}

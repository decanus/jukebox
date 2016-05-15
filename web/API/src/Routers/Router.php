<?php

namespace Jukebox\API\Routers
{

    use Jukebox\API\AccessControl;
    use Jukebox\API\Exceptions\Forbidden;
    use Jukebox\Framework\Controllers\ControllerInterface;
    use Jukebox\Framework\Http\Request\RequestInterface;

    class Router extends \Jukebox\Framework\Routers\Router
    {
        /**
         * @var AccessControl
         */
        private $accessControl;

        public function __construct(AccessControl $accessControl)
        {
            $this->accessControl = $accessControl;
        }

        public function route(RequestInterface $request): ControllerInterface
        {
            if (!$this->accessControl->hasPermissions($request)) {
                throw new Forbidden('Forbidden');
            }

            return parent::route($request);
        }

    }
}

<?php

namespace Jukebox\API\Endpoints\v1\Me
{

    use Jukebox\API\Endpoints\AbstractEndpoint;
    use Jukebox\Framework\Controllers\ControllerInterface;
    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\ParamterObjects\ControllerParameterObject;

    class GetMeEndpoint extends AbstractEndpoint
    {

        protected function doHandle(RequestInterface $request): ControllerInterface
        {
            return $this->getFactory()->createGetMeController(new ControllerParameterObject($request->getUri()));
        }

        public function getApiEndpoint(): string
        {
            return '/v1/me';
        }

        public function requiresAccessToken(): bool
        {
            return true;
        }

        public function getRequestType(): string
        {
            return \Jukebox\Framework\Http\Request\GetRequest::class;
        }
    }
}

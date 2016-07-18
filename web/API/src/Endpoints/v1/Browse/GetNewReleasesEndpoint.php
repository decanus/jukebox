<?php

namespace Jukebox\API\Endpoints\v1\Browse
{

    use Jukebox\API\Endpoints\AbstractEndpoint;
    use Jukebox\Framework\Controllers\ControllerInterface;
    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\ParamterObjects\ControllerParameterObject;

    class GetNewReleasesEndpoint extends AbstractEndpoint
    {

        protected function doHandle(RequestInterface $request): ControllerInterface
        {
            return $this->getFactory()->createGetNewReleasesController(new ControllerParameterObject($request->getUri()));
        }

        public function getApiEndpoint(): string
        {
            return '/v1/browse/new-releases';
        }

        public function requiresAccessToken(): bool
        {
            return false;
        }

        public function getRequestType(): string
        {
            return \Jukebox\Framework\Http\Request\GetRequest::class;
        }
    }
}

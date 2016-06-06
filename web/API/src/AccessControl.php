<?php

namespace Jukebox\API
{

    use Jukebox\API\Endpoints\EndpointInterface;
    use Jukebox\Framework\Http\Request\RequestInterface;

    class AccessControl
    {
        /**
         * @var array
         */
        private $accessTokens;

        public function __construct(array $accessTokens)
        {
            $this->accessTokens = $accessTokens;
        }

        public function hasPermissions(RequestInterface $request, EndpointInterface $endpoint): bool
        {
            if ($request->getUri()->getPath() === '/') {
                return true;
            }

            if ($endpoint->requiresAccessToken() && !$request->hasParameter('access_token')) {
                return false;
            }

            if (!$request->hasParameter('key')) {
                return false;
            }

            if (!isset($this->accessTokens[$request->getParameter('key')])) {
                return false;
            }

            return true;
        }
    }
}

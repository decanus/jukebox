<?php

namespace Jukebox\API
{

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

        public function hasPermissions(RequestInterface $request): bool
        {
            if ($request->getUri()->getPath() === '/') {
                return true;
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

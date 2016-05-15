<?php

namespace Jukebox\Framework\Http\Request
{

    use Jukebox\Framework\ValueObjects\Uri;

    abstract class AbstractRequest implements RequestInterface
    {
        /**
         * @var array
         */
        private $parameters;

        /**
         * @var array
         */
        private $server;

        /**
         * @var array
         */
        private $cookies;

        /**
         * @var Uri
         */
        private $uri;

        /**
         * @param array $parameters
         * @param array $server
         * @param array $cookies
         */
        public function __construct($parameters = [], $server = [], $cookies = [])
        {
            $this->parameters = $parameters;
            $this->server = $server;
            $this->cookies = $cookies;
        }

        /**
         * @param string $key
         *
         * @return string
         * @throws \Exception
         */
        public function getCookieParameter($key): string
        {
            if (!$this->hasCookieParameter($key)) {
                throw new \Exception('Cookie "' . $key . '" not set');
            }

            return $this->cookies[$key];
        }

        /**
         * @param string $key
         *
         * @return bool
         */
        public function hasCookieParameter($key): bool
        {
            return isset($this->cookies[$key]);
        }

        /**
         * @param string $key
         */
        public function removeCookieParameter($key)
        {
            unset($this->cookies[$key]);
        }

        /**
         * @param string $key
         *
         * @return string
         * @throws \Exception
         */
        public function getServerParameter($key): string
        {
            if (!$this->hasServerParameter($key)) {
                throw new \Exception('Server parameter "' . $key . '" not set');
            }

            return $this->server[$key];
        }

        /**
         * @param string $key
         *
         * @return bool
         */
        public function hasServerParameter($key): bool
        {
            return isset($this->server[$key]);
        }

        /**
         * @param string $key
         *
         * @return string
         * @throws \Exception
         */
        public function getParameter($key): string
        {
            if (!$this->hasParameter($key)) {
                throw new \Exception('Parameter "' . $key . '" not found');
            }

            return $this->parameters[$key];
        }

        /**
         * @param string $key
         *
         * @return bool
         */
        public function hasParameter($key): bool
        {
            return isset($this->parameters[$key]);
        }

        /**
         * @return string
         */
        public function getReferer(): string
        {
            return $this->getServerParameter('HTTP_REFERER');
        }

        /**
         * @return string
         */
        public function getHost(): string
        {
            return $this->getServerParameter('HTTP_HOST');
        }

        /**
         * @return string
         */
        public function getUserAgent(): string
        {
            if ($this->hasServerParameter('HTTP_USER_AGENT')) {
                return $this->getServerParameter('HTTP_USER_AGENT');
            }
        }

        /**
         * @return string
         */
        public function getUserIP(): string
        {
            return $this->getServerParameter('REMOTE_ADDR');
        }

        /**
         * @return array
         */
        public function getParameters(): array
        {
            return $this->parameters;
        }

        /**
         * @return Uri
         */
        public function getUri(): Uri
        {
            if ($this->uri === null) {
                $this->uri = new Uri('https://' . $this->getHost() . $this->getServerParameter('REQUEST_URI'));
            }

            return $this->uri;
        }
    }
}

<?php

namespace Jukebox\Framework\ValueObjects
{
    class Cookie
    {
        /**
         * @var string
         */
        private $name;

        /**
         * @var string
         */
        private $value;

        /**
         * @var string
         */
        private $path;

        /**
         * @var string
         */
        private $expires;

        /**
         * @var string
         */
        private $domain;

        /**
         * @var bool
         */
        private $secure;

        /**
         * @var bool
         */
        private $httpOnly;

        /**
         * @param string $name
         * @param string $value
         * @param string $path
         * @param string $expires
         * @param string $domain
         * @param bool   $secure
         * @param bool   $httpOnly
         */
        public function __construct($name, $value, $path = '/', $expires, $domain = '.Jukebox.me', $secure = true, $httpOnly = true)
        {
            $this->name = $name;
            $this->value = $value;
            $this->path = $path;
            $this->expires = $expires;
            $this->domain = $domain;
            $this->secure = $secure;
            $this->httpOnly = $httpOnly;
        }

        /**
         * @return string
         */
        public function getName(): string
        {
            return $this->name;
        }

        /**
         * @return string
         */
        public function getValue(): string
        {
            return $this->value;
        }

        /**
         * @return string
         */
        public function getPath(): string
        {
            return $this->path;
        }

        /**
         * @return string
         */
        public function getExpires(): string
        {
            return $this->expires;
        }

        /**
         * @return string
         */
        public function getDomain(): string
        {
            return $this->domain;
        }

        /**
         * @return bool
         */
        public function isSecure(): bool
        {
            return $this->secure;
        }

        /**
         * @return bool
         */
        public function isHttpOnly(): bool
        {
            return $this->httpOnly;
        }
    }
}

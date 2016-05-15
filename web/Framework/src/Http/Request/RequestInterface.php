<?php

namespace Jukebox\Framework\Http\Request
{

    use Jukebox\Framework\ValueObjects\Uri;

    interface RequestInterface
    {
        /**
         * @param string $key
         *
         * @return string
         * @throws \Exception
         */
        public function getCookieParameter($key): string;

        /**
         * @param string $key
         *
         * @return bool
         */
        public function hasCookieParameter($key): bool;

        /**
         * @param string $key
         *
         * @return string
         * @throws \Exception
         */
        public function getServerParameter($key): string;

        /**
         * @param string $key
         *
         * @return bool
         */
        public function hasServerParameter($key): bool;

        /**
         * @param string $key
         *
         * @return string
         * @throws \Exception
         */
        public function getParameter($key): string;

        /**
         * @param string $key
         *
         * @return bool
         */
        public function hasParameter($key): bool;

        /**
         * @return Uri
         */
        public function getUri(): Uri;
    }
}

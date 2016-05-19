<?php

namespace Jukebox\Framework\Factories
{
    class ApplicationFactory extends AbstractFactory
    {
        public function createCurl(): \Jukebox\Framework\Curl\Curl
        {
            return new \Jukebox\Framework\Curl\Curl(
                new \Jukebox\Framework\Curl\CurlHandler,
                new \Jukebox\Framework\Curl\CurlMultiHandler
            );
        }

        public function createRollingCurl(): \Jukebox\Framework\Curl\RollingCurl
        {
            return new \Jukebox\Framework\Curl\RollingCurl;
        }
    }
}

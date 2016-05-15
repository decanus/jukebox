<?php

namespace Jukebox\Framework\Factories
{
    class ApplicationFactory extends AbstractFactory
    {
        public function createCurl()
        {
            return new \Jukebox\Framework\Curl\Curl(
                new \Jukebox\Framework\Curl\CurlHandler,
                new \Jukebox\Framework\Curl\CurlMultiHandler
            );
        }
    }
}

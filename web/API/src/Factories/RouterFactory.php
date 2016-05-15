<?php

namespace Jukebox\API\Factories
{

    use Jukebox\Framework\Factories\AbstractFactory;

    class RouterFactory extends AbstractFactory
    {
        public function createGetRequestRouter(): \Jukebox\API\Routers\GetRequestRouter
        {
            return new \Jukebox\API\Routers\GetRequestRouter($this->getMasterFactory());
        }

        public function createIndexRouter(): \Jukebox\API\Routers\IndexRouter
        {
            return new \Jukebox\API\Routers\IndexRouter($this->getMasterFactory());
        }

        public function createErrorRouter(): \Jukebox\API\Routers\ErrorRouter
        {
            return new \Jukebox\API\Routers\ErrorRouter($this->getMasterFactory());
        }
    }
}

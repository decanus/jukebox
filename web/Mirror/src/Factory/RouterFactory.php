<?php

namespace Jukebox\Mirror\Factories
{

    use Jukebox\Framework\Factories\AbstractFactory;

    class RouterFactory extends AbstractFactory
    {
        public function createPageRouter(): \Jukebox\Mirror\Routers\PageRouter
        {
            return new \Jukebox\Mirror\Routers\PageRouter(
                $this->getMasterFactory()
            );
        }
    }
}

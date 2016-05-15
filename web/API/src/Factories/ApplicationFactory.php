<?php

namespace Jukebox\API\Factories
{
    class ApplicationFactory extends \Jukebox\Framework\Factories\ApplicationFactory
    {
        public function createAccessControl(): \Jukebox\API\AccessControl
        {
            return new \Jukebox\API\AccessControl(
                json_decode($this->getMasterFactory()->createFileBackend()->load(__DIR__ . '/../../config/accessTokens.json'), true)
            );
        }
    }
}

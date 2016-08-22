<?php

namespace Jukebox\Backend\Factories
{

    use Jukebox\Framework\Factories\AbstractFactory;
    use Jukebox\Framework\ValueObjects\Uri;

    class ServiceFactory extends AbstractFactory
    {
        public function createVevoService()
        {
            return new \Jukebox\Backend\Services\Vevo(
                new Uri('http://apiv2.vevo.com'),
                $this->getMasterFactory()->createCurl(),
                $this->getMasterFactory()->createRollingCurl(),
                $this->getMasterFactory()->createRedisBackend()
            );
        }
        public function createSoundcloudService()
        {
            return new \Jukebox\Backend\Services\Soundcloud(
                new Uri($this->getMasterFactory()->getConfiguration()->get('soundcloudApiUri')),
                $this->getMasterFactory()->createCurl(),
                $this->getMasterFactory()->createRollingCurl(),
                $this->getMasterFactory()->getConfiguration()->get('soundcloudClientId')
            );
        }
    }
}

<?php

namespace Jukebox\Framework\Factories
{

    use Jukebox\Framework\DataPool\DataPoolKeyGenerator;
    use Jukebox\Framework\ValueObjects\DataVersion;
    use Jukebox\Framework\ValueObjects\Uri;

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

        public function createElasticsearchClient(): \Elasticsearch\Client
        {
            return (new \Elasticsearch\ClientBuilder())->build();
        }

        public function createDataPoolWriter(DataVersion $dataVersion = null): \Jukebox\Framework\DataPool\DataPoolWriter
        {
            return new \Jukebox\Framework\DataPool\DataPoolWriter(
                new DataPoolKeyGenerator,
                $this->getMasterFactory()->createRedisBackend(),
                $dataVersion
            );
        }

        public function createDataPoolReader(DataVersion $dataVersion = null): \Jukebox\Framework\DataPool\DataPoolReader
        {
            return new \Jukebox\Framework\DataPool\DataPoolReader(
                new DataPoolKeyGenerator,
                $this->getMasterFactory()->createRedisBackend(),
                $dataVersion
            );
        }
        
        public function createJukeboxRestManager(): \Jukebox\Framework\Rest\JukeboxRestManager
        {
            return new \Jukebox\Framework\Rest\JukeboxRestManager(
                $this->getMasterFactory()->createCurl(),
                new Uri($this->getMasterFactory()->getConfiguration()->get('apiEndpoint')),
                $this->getMasterFactory()->getConfiguration()->get('apiKey')
            );
        }
    }
}

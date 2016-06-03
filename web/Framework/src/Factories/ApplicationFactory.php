<?php

namespace Jukebox\Framework\Factories
{

    use Jukebox\Framework\DataPool\DataPoolKeyGenerator;

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

        public function createDataPoolWriter(): \Jukebox\Framework\DataPool\DataPoolWriter
        {
            return new \Jukebox\Framework\DataPool\DataPoolWriter(
                new DataPoolKeyGenerator,
                $this->getMasterFactory()->createRedisBackend()
            );
        }
    }
}

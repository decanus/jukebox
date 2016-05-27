<?php

namespace Jukebox\Backend\EventHandlers\Push
{

    use Elasticsearch\Client;
    use Jukebox\Backend\EventHandlers\EventHandlerInterface;

    class ElasticsearchIndexPushEventHandler implements EventHandlerInterface
    {
        /**
         * @var Client
         */
        private $client;

        public function __construct(Client $client)
        {
            $this->client = $client;
        }

        public function execute()
        {
            $this->client->indices()->create([]);
            $this->client->indices()->putMapping([]);
        }
    }
}

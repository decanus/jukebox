<?php

namespace Jukebox\Backend\EventHandlers
{

    use Elasticsearch\Client;

    class SwitchElasticsearchIndexEventHandler implements EventHandlerInterface
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
        }
    }
}

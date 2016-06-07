<?php

namespace Jukebox\Backend\EventHandlers
{

    use Elasticsearch\Client;
    use Jukebox\Backend\Events\ElasticsearchIndexDeleteEvent;

    class ElasticsearchIndexDeleteEventHandler implements EventHandlerInterface
    {
        /**
         * @var ElasticsearchIndexDeleteEvent
         */
        private $event;
        
        /**
         * @var Client
         */
        private $client;

        public function __construct(ElasticsearchIndexDeleteEvent $event, Client $client)
        {
            $this->event = $event;
            $this->client = $client;
        }
        
        public function execute()
        {
            $this->client->indices()->delete(['index' => $this->event->getIndex()]);
        }
    }
}

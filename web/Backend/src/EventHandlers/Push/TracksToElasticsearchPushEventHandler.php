<?php

namespace Jukebox\Backend\EventHandlers\Push
{

    use Elasticsearch\Client;
    use Jukebox\Backend\EventHandlers\EventHandlerInterface;
    use Jukebox\Backend\Events\TracksToElasticsearchPushEvent;

    class TracksToElasticsearchPushEventHandler implements EventHandlerInterface
    {
        /**
         * @var TracksToElasticsearchPushEvent
         */
        private $event;

        /**
         * @var Client
         */
        private $client;

        public function __construct(
            TracksToElasticsearchPushEvent $event,
            Client $client
        )
        {
            $this->event = $event;
            $this->client = $client;
        }

        public function execute()
        {

        }
    }
}

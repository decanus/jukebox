<?php

namespace Jukebox\Backend\EventHandlers\Push
{

    use Elasticsearch\Client;
    use Jukebox\Backend\EventHandlers\EventHandlerInterface;
    use Jukebox\Backend\Events\ElasticsearchIndexPushEvent;
    use Jukebox\Framework\Backends\FileBackend;

    class ElasticsearchIndexPushEventHandler implements EventHandlerInterface
    {
        /**
         * @var ElasticsearchIndexPushEvent
         */
        private $event;

        /**
         * @var Client
         */
        private $client;

        /**
         * @var FileBackend
         */
        private $fileBackend;

        /**
         * @var string
         */
        private $mappingsPath;

        public function __construct(
            ElasticsearchIndexPushEvent $event,
            Client $client,
            FileBackend $fileBackend,
            string $mappingsPath
        )
        {
            $this->client = $client;
            $this->event = $event;
            $this->fileBackend = $fileBackend;
            $this->mappingsPath = $mappingsPath;
        }

        public function execute()
        {
            $this->client->indices()->create(
                ['index' => $this->event->getDataVersion()]
            );
            $this->client->indices()->putMapping([]);
        }
    }
}

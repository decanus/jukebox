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
            $dataVersion = $this->event->getDataVersion();

            $this->client->indices()->create(
                ['index' => $dataVersion]
            );
            
            $files = $this->fileBackend->scanDirectory($this->mappingsPath, ['*.json']);

            /*** @var $file \SplFileInfo */
            foreach ($files as $file) {
                $mapping = json_decode($this->fileBackend->load($file->getRealPath()), true);

                $params['index'] = $dataVersion;
                $params['type'] = array_keys($mapping)[0];
                $params['body'] = $mapping;

                $this->client->indices()->putMapping($mapping);
            }
        }
    }
}

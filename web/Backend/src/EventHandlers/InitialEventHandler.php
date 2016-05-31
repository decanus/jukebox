<?php

namespace Jukebox\Backend\EventHandlers
{

    use Jukebox\Backend\Events\ArtistsToElasticsearchPushEvent;
    use Jukebox\Backend\Events\ElasticsearchIndexPushEvent;
    use Jukebox\Backend\Events\InitialVevoArtistsImportEvent;
    use Jukebox\Backend\Events\InitialVevoArtistsVideosImportEvent;
    use Jukebox\Backend\Events\TracksToElasticsearchPushEvent;
    use Jukebox\Backend\Writers\EventQueueWriter;
    use Jukebox\Framework\DataPool\RedisBackend;
    use Jukebox\Framework\ValueObjects\DataVersion;

    class InitialEventHandler implements EventHandlerInterface
    {
        /**
         * @var EventQueueWriter
         */
        private $eventQueueWriter;

        /**
         * @var RedisBackend
         */
        private $redisBackend;

        public function __construct(
            EventQueueWriter $eventQueueWriter,
            RedisBackend $redisBackend
        )
        {
            $this->eventQueueWriter = $eventQueueWriter;
            $this->redisBackend = $redisBackend;
        }

        public function execute()
        {
            $dataVersion = new DataVersion('now');

            // @todo into cron file
            // $this->eventQueueWriter->add(new InitialVevoArtistsImportEvent);
            // $this->eventQueueWriter->add(new InitialVevoArtistsVideosImportEvent);


            // @todo this wont work
            $this->eventQueueWriter->add(new ElasticsearchIndexPushEvent($dataVersion));
            $this->eventQueueWriter->add(new ArtistsToElasticsearchPushEvent($dataVersion));
            $this->eventQueueWriter->add(new TracksToElasticsearchPushEvent($dataVersion));

            $this->redisBackend->set('currentDataVersion', (string) $dataVersion);
        }
    }
}

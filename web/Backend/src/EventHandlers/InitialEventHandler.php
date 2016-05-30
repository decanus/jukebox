<?php

namespace Jukebox\Backend\EventHandlers
{

    use Jukebox\Backend\Events\ArtistsToElasticsearchPushEvent;
    use Jukebox\Backend\Events\ElasticsearchIndexPushEvent;
    use Jukebox\Backend\Events\InitialVevoArtistsImportEvent;
    use Jukebox\Backend\Events\InitialVevoArtistsVideosImportEvent;
    use Jukebox\Backend\Events\TracksToElasticsearchPushEvent;
    use Jukebox\Backend\Writers\EventQueueWriter;
    use Jukebox\Framework\ValueObjects\DataVersion;

    class InitialEventHandler implements EventHandlerInterface
    {
        /**
         * @var EventQueueWriter
         */
        private $eventQueueWriter;

        public function __construct(EventQueueWriter $eventQueueWriter)
        {
            $this->eventQueueWriter = $eventQueueWriter;
        }

        public function execute()
        {
            $dataVersion = new DataVersion('now');

            $this->eventQueueWriter->add(new InitialVevoArtistsImportEvent);
            $this->eventQueueWriter->add(new InitialVevoArtistsVideosImportEvent);
            $this->eventQueueWriter->add(new ElasticsearchIndexPushEvent($dataVersion));
            $this->eventQueueWriter->add(new ArtistsToElasticsearchPushEvent($dataVersion));
            $this->eventQueueWriter->add(new TracksToElasticsearchPushEvent($dataVersion));
        }
    }
}

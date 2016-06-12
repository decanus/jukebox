<?php

namespace Jukebox\Backend\EventHandlers
{

    use Jukebox\Backend\Events\ArtistPathsPushEvent;
    use Jukebox\Backend\Events\ArtistsToElasticsearchPushEvent;
    use Jukebox\Backend\Events\DataVersionPushEvent;
    use Jukebox\Backend\Events\ElasticsearchIndexDeleteEvent;
    use Jukebox\Backend\Events\ElasticsearchIndexPushEvent;
    use Jukebox\Backend\Events\OldDataVersionDeleteEvent;
    use Jukebox\Backend\Events\TrackPathsPushEvent;
    use Jukebox\Backend\Events\TracksToElasticsearchPushEvent;
    use Jukebox\Backend\Writers\EventQueueWriter;
    use Jukebox\Framework\ValueObjects\DataVersion;

    class InitialEventHandler implements EventHandlerInterface
    {
        /**
         * @var EventQueueWriter
         */
        private $eventQueueWriter;

        /**
         * @var bool
         */
        private $validateDataVersionPushFinished;

        public function __construct(EventQueueWriter $eventQueueWriter, $validateDataVersionPushFinished = true)
        {
            $this->eventQueueWriter = $eventQueueWriter;
            $this->validateDataVersionPushFinished = $validateDataVersionPushFinished;
        }

        public function execute()
        {
            $oldDataVersion = $this->eventQueueWriter->getDataVersion();
            $dataVersion = new DataVersion('now');
            $this->eventQueueWriter->add(new ElasticsearchIndexPushEvent($dataVersion));
            $this->eventQueueWriter->add(new ArtistsToElasticsearchPushEvent($dataVersion));
            $this->eventQueueWriter->add(new TracksToElasticsearchPushEvent($dataVersion));
            $this->eventQueueWriter->add(new TrackPathsPushEvent($dataVersion));
            $this->eventQueueWriter->add(new ArtistPathsPushEvent($dataVersion));

            if ($this->validateDataVersionPushFinished) {
                $this->wait();
            }
            
            $this->eventQueueWriter->add(new DataVersionPushEvent($dataVersion));
            $this->eventQueueWriter->add(new OldDataVersionDeleteEvent($oldDataVersion));
            $this->eventQueueWriter->add(new ElasticsearchIndexDeleteEvent($oldDataVersion));
        }

        private function wait()
        {
            while ($this->eventQueueWriter->count() > 0) {
                sleep(15);
            }
        }
    }
}

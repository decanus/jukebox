<?php

namespace Jukebox\Backend\EventHandlers\Push
{

    use Jukebox\Backend\EventHandlers\EventHandlerInterface;
    use Jukebox\Backend\Events\InitialTrackDataPoolPushEvent;
    use Jukebox\Backend\Events\TrackDataPoolPushEvent;
    use Jukebox\Backend\Queries\FetchTrackIdsQuery;
    use Jukebox\Backend\Writers\EventQueueWriter;

    class InitialTrackDataPoolPushEventHandler implements EventHandlerInterface
    {
        /**
         * @var InitialTrackDataPoolPushEvent
         */
        private $event;

        /**
         * @var EventQueueWriter
         */
        private $eventQueueWriter;

        /**
         * @var FetchTrackIdsQuery
         */
        private $fetchTrackIdsQuery;

        public function __construct(
            InitialTrackDataPoolPushEvent $event,
            EventQueueWriter $eventQueueWriter,
            FetchTrackIdsQuery $fetchTrackIdsQuery
        )
        {
            $this->event = $event;
            $this->eventQueueWriter = $eventQueueWriter;
            $this->fetchTrackIdsQuery = $fetchTrackIdsQuery;
        }

        public function execute()
        {
            $tracks = $this->fetchTrackIdsQuery->execute();

            foreach ($tracks as $track) {
                $this->eventQueueWriter->add(new TrackDataPoolPushEvent($this->event->getDataVersion(), $track['id']));
            }
        }
    }
}

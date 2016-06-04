<?php

namespace Jukebox\Backend\EventHandlers\Push
{

    use Jukebox\Backend\EventHandlers\EventHandlerInterface;
    use Jukebox\Backend\Queries\FetchTrackPathsQuery;
    use Jukebox\Framework\DataPool\DataPoolWriter;

    class TrackPathsPushEventHandler implements EventHandlerInterface
    {
        /**
         * @var FetchTrackPathsQuery
         */
        private $fetchTrackPathsQuery;

        /**
         * @var DataPoolWriter
         */
        private $writer;

        public function __construct(FetchTrackPathsQuery $fetchTrackPathsQuery, DataPoolWriter $writer)
        {
            $this->writer = $writer;
            $this->fetchTrackPathsQuery = $fetchTrackPathsQuery;
        }

        public function execute()
        {
                $tracks = $this->fetchTrackPathsQuery->execute();

            foreach ($tracks as $track) {
                $this->writer->setTrackIdForPath($track['permalink'], $track['id']);
            }
        }
    }
}

<?php

namespace Jukebox\Backend\EventHandlers\Import
{

    use Jukebox\Backend\EventHandlers\EventHandlerInterface;
    use Jukebox\Backend\Events\VevoArtistVideosImportEvent;
    use Jukebox\Backend\Queries\FetchVevoArtistsQuery;
    use Jukebox\Backend\Writers\EventQueueWriter;
    use Jukebox\Framework\Logging\LoggerAware;
    use Jukebox\Framework\Logging\LoggerAwareTrait;

    class InitialVevoArtistsVideosImportEventHandler implements EventHandlerInterface, LoggerAware
    {
        /**
         * @trait
         */
        use LoggerAwareTrait;

        /**
         * @var FetchVevoArtistsQuery
         */
        private $fetchVevoArtistsQuery;

        /**
         * @var EventQueueWriter
         */
        private $eventQueueWriter;

        public function __construct(
            FetchVevoArtistsQuery $fetchVevoArtistsQuery,
            EventQueueWriter $eventQueueWriter
        )
        {
            $this->fetchVevoArtistsQuery = $fetchVevoArtistsQuery;
            $this->eventQueueWriter = $eventQueueWriter;
        }

        public function execute()
        {
            try {
                $artists = $this->fetchVevoArtistsQuery->execute();

                foreach ($artists as $artist) {
                    $this->eventQueueWriter->add(new VevoArtistVideosImportEvent($artist['vevo_id']));
                }
            } catch (\Throwable $e) {
                $this->getLogger()->critical($e);
            }
        }
    }
}

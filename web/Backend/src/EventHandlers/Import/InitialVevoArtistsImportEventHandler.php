<?php

namespace Jukebox\Backend\EventHandlers\Import
{

    use Jukebox\Backend\EventHandlers\EventHandlerInterface;
    use Jukebox\Backend\Events\VevoArtistImportEvent;
    use Jukebox\Backend\Services\Vevo;
    use Jukebox\Backend\Writers\EventQueueWriter;
    use Jukebox\Framework\Logging\LoggerAware;
    use Jukebox\Framework\Logging\LoggerAwareTrait;

    class InitialVevoArtistsImportEventHandler implements EventHandlerInterface, LoggerAware
    {
        /**
         * @trait
         */
        use LoggerAwareTrait;

        /**
         * @var Vevo
         */
        private $vevo;

        /**
         * @var EventQueueWriter
         */
        private $eventQueueWriter;

        public function __construct(Vevo $vevo, EventQueueWriter $eventQueueWriter)
        {
            $this->vevo = $vevo;
            $this->eventQueueWriter = $eventQueueWriter;
        }

        public function execute()
        {
            try {
                $artists = $this->vevo->getArtists()->getDecodedJsonResponse();

                foreach ($artists['artists'] as $artist) {
                    $this->handleArtist($artist);
                }

                $pages = $artists['paging']['pages'];
                for ($i = 2; $i <= $pages; $i++) {
                    $artists = $this->vevo->getArtists($i)->getDecodedJsonResponse()['artists'];

                    foreach ($artists as $artist) {
                        $this->handleArtist($artist);
                    }
                }

            } catch (\Exception $e) {
                $this->getLogger()->critical($e);
            }
        }

        private function handleArtist(array $artist)
        {
            if ($artist['urlSafeName'] === 'vevo') {
                return;
            }

            $this->eventQueueWriter->add(new VevoArtistImportEvent($artist['urlSafeName']));
        }
    }
}

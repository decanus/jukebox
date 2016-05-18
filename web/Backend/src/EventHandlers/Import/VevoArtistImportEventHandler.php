<?php

namespace Jukebox\Backend\EventHandlers\Import
{

    use Jukebox\Backend\EventHandlers\EventHandlerInterface;
    use Jukebox\Backend\Events\VevoArtistImportEvent;
    use Jukebox\Backend\Services\Vevo;
    use Jukebox\Framework\Logging\LoggerAware;
    use Jukebox\Framework\Logging\LoggingProvider;

    class VevoArtistImportEventHandler implements EventHandlerInterface, LoggerAware
    {
        /**
         * @trait
         */
        use LoggingProvider;

        /**
         * @var VevoArtistImportEvent
         */
        private $event;

        /**
         * @var Vevo
         */
        private $vevo;

        public function __construct(
            VevoArtistImportEvent $event,
            Vevo $vevo
        )
        {
            $this->event = $event;
            $this->vevo = $vevo;
        }

        public function execute()
        {
            try {

                $response = $this->vevo->getArtist($this->event->getArtist());

                if ($response->getResponseCode() !== 200) {
                    throw new \Exception('Artist could not be imported');
                }

                $artist = $response->getDecodedJsonResponse();

            } catch (\Exception $e) {
                // @todo log
                throw $e;
            }
        }
    }
}

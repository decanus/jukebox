<?php

namespace Jukebox\Backend\EventHandlers\Import
{

    use Jukebox\Backend\Commands\InsertVevoArtistCommand;
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

        /**
         * @var InsertVevoArtistCommand
         */
        private $insertArtistCommand;

        public function __construct(
            VevoArtistImportEvent $event,
            Vevo $vevo,
            InsertVevoArtistCommand $insertArtistCommand
        )
        {
            $this->event = $event;
            $this->vevo = $vevo;
            $this->insertArtistCommand = $insertArtistCommand;
        }

        public function execute()
        {
            try {

                $response = $this->vevo->getArtist($this->event->getArtist());

                if ($response->getResponseCode() !== 200) {
                    throw new \Exception('Artist could not be imported');
                }

                $artist = $response->getDecodedJsonResponse();

                $result = $this->insertArtistCommand->execute($artist['name'], $artist['urlSafeName']);

                if (!$result) {
                    throw new \Exception('Inserting artist failed');
                }

            } catch (\Exception $e) {
                // @todo log
                throw $e;
            }
        }
    }
}

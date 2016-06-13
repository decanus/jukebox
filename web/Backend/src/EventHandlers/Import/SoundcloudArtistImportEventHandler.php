<?php

namespace Jukebox\Backend\EventHandlers\Import
{

    use Jukebox\Backend\Commands\InsertArtistCommand;
    use Jukebox\Backend\EventHandlers\EventHandlerInterface;
    use Jukebox\Backend\Events\SoundcloudArtistImportEvent;
    use Jukebox\Backend\Services\Soundcloud;
    use Jukebox\Framework\Logging\LoggerAware;
    use Jukebox\Framework\Logging\LoggerAwareTrait;

    class SoundcloudArtistImportEventHandler implements EventHandlerInterface, LoggerAware
    {
        use LoggerAwareTrait;

        /**
         * @var SoundcloudArtistImportEvent
         */
        private $event;

        /**
         * @var Soundcloud
         */
        private $soundcloud;
        
        /**
         * @var InsertArtistCommand
         */
        private $insertArtistCommand;

        public function __construct(
            SoundcloudArtistImportEvent $event,
            Soundcloud $soundcloud,
            InsertArtistCommand $insertArtistCommand
        )
        {
            $this->event = $event;
            $this->soundcloud = $soundcloud;
            $this->insertArtistCommand = $insertArtistCommand;
        }

        public function execute()
        {
            try {

                $id = $this->event->getSoundcloudId();
                $response = $this->soundcloud->getArtist($id);

                if ($response->getResponseCode() !== 200) {
                    throw new \RuntimeException('Failed downloading soundcloud artist "' . $id . '" server responded with "' . $response->getResponseCode() . '"');
                }

                $artist = $response->getDecodedJsonResponse();

                $webProfiles = $this->soundcloud->getArtistWebProfiles($id)->getDecodedJsonResponse();
                var_dump($artist);exit;

            } catch (\Throwable $e) {
                $this->getLogger()->critical($e);
            }
        }
    }
}

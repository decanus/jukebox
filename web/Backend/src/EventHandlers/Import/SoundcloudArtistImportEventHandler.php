<?php

namespace Jukebox\Backend\EventHandlers\Import
{

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

        public function __construct(
            SoundcloudArtistImportEvent $event,
            Soundcloud $soundcloud
        )
        {
            $this->soundcloud = $soundcloud;
            $this->event = $event;
        }

        public function execute()
        {
            try {

                $id = $this->event->getSoundcloudId();
                $response = $this->soundcloud->getArtist($id);

                if ($response->getResponseCode() !== 200) {
                    throw new \RuntimeException('Failed downloading soundcloud artist "' . $id . '" server responded with "' . $response->getResponseCode() . '"');
                }

            } catch (\Throwable $e) {
                $this->getLogger()->critical($e);
            }
        }
    }
}

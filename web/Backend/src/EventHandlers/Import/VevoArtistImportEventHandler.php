<?php

namespace Jukebox\Backend\EventHandlers\Import
{

    use Jukebox\Backend\Commands\InsertVevoArtistCommand;
    use Jukebox\Backend\EventHandlers\EventHandlerInterface;
    use Jukebox\Backend\Events\VevoArtistImportEvent;
    use Jukebox\Backend\Services\Vevo;
    use Jukebox\Framework\Logging\LoggerAware;
    use Jukebox\Framework\Logging\LoggerAwareTrait;
    use Jukebox\Framework\ValueObjects\Uri;

    class VevoArtistImportEventHandler implements EventHandlerInterface, LoggerAware
    {
        /**
         * @trait
         */
        use LoggerAwareTrait;

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

                // @todo check if we already have the artist

                $response = $this->vevo->getArtist($this->event->getArtist());

                if ($response->getResponseCode() !== 200) {
                    throw new \Exception('Artist could not be imported');
                }

                $artist = $response->getDecodedJsonResponse();

                $officialWebsite = null;
                $twitter = null;
                $facebook = null;
                $itunes = null;
                $amazon = null;

                foreach ($artist['links'] as $link) {
                    try {
                        if ($link['type'] === 'Facebook') {
                            $facebook = new Uri($link['url']);
                            continue;
                        }

                        if ($link['type'] === 'Twitter') {
                            $twitter = $link['userName'];
                            continue;
                        }

                        if ($link['type'] === 'Official Website') {
                            $officialWebsite = new Uri($link['url']);
                            continue;
                        }
                    } catch (\Throwable $e) {
                        continue;
                    }
                }

                foreach ($artist['buyLinks'] as $link) {
                    try {
                        if ($link['vendor'] === 'iTunes') {
                            $itunes = new Uri($link['url']);
                            continue;
                        }

                        if ($link['vendor'] === 'Amazon') {
                            $officialWebsite = new Uri($link['url']);
                            continue;
                        }
                    } catch (\Throwable $e) {
                        continue;
                    }
                }

                $result = $this->insertArtistCommand->execute(
                    $artist['name'],
                    $artist['urlSafeName'],
                    $officialWebsite,
                    $twitter,
                    $facebook,
                    $itunes,
                    $amazon
                );
                
                if (!$result) {
                    throw new \Exception('Inserting artist failed');
                }

            } catch (\Exception $e) {
                $this->getLogger()->critical($e);
            }
        }
    }
}

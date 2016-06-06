<?php

namespace Jukebox\Backend\EventHandlers\Import
{

    use Jukebox\Backend\Commands\InsertArtistCommand;
    use Jukebox\Backend\EventHandlers\EventHandlerInterface;
    use Jukebox\Backend\Events\VevoArtistImportEvent;
    use Jukebox\Backend\Queries\FetchArtistByVevoIdBackendQuery;
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
         * @var InsertArtistCommand
         */
        private $insertArtistCommand;

        /**
         * @var FetchArtistByVevoIdBackendQuery
         */
        private $fetchArtistByVevoIdQuery;

        public function __construct(
            VevoArtistImportEvent $event,
            Vevo $vevo,
            InsertArtistCommand $insertArtistCommand,
            FetchArtistByVevoIdBackendQuery $fetchArtistByVevoIdQuery
        )
        {
            $this->event = $event;
            $this->vevo = $vevo;
            $this->insertArtistCommand = $insertArtistCommand;
            $this->fetchArtistByVevoIdQuery = $fetchArtistByVevoIdQuery;
        }

        public function execute()
        {
            $artistName = $this->event->getArtist();

            try {
                if (is_array($this->fetchArtistByVevoIdQuery->execute($artistName))) {
                    return;
                }
            } catch (\Throwable $e) {
                $this->getLogger()->warning($e);
                return;
            }

            try {
                $response = $this->vevo->getArtist($artistName);

                if ($response->getResponseCode() !== 200) {
                    var_dump($response->getDecodedJsonResponse());
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
                            $amazon = new Uri($link['url']);
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
                    $amazon,
                    strtolower('/' . $artist['urlSafeName'])
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

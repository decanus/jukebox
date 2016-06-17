<?php

namespace Jukebox\Backend\EventHandlers\Import
{

    use Imagick;
    use Jukebox\Backend\Commands\InsertArtistCommand;
    use Jukebox\Backend\EventHandlers\EventHandlerInterface;
    use Jukebox\Backend\Events\VevoArtistImportEvent;
    use Jukebox\Backend\Queries\FetchArtistByVevoIdQuery;
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
         * @var FetchArtistByVevoIdQuery
         */
        private $fetchArtistByVevoIdQuery;

        public function __construct(
            VevoArtistImportEvent $event,
            Vevo $vevo,
            InsertArtistCommand $insertArtistCommand,
            FetchArtistByVevoIdQuery $fetchArtistByVevoIdQuery
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
                    throw new \Exception('Artist "' . $artistName . '" could not be imported');
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
                            $facebook = new Uri(trim($link['url']));
                            continue;
                        }

                        if ($link['type'] === 'Twitter') {
                            $twitter = $link['userName'];
                            continue;
                        }

                        if ($link['type'] === 'Official Website') {
                            $officialWebsite = new Uri(trim($link['url']));
                            continue;
                        }
                    } catch (\Throwable $e) {
                        continue;
                    }
                }

                foreach ($artist['buyLinks'] as $link) {
                    try {
                        if ($link['vendor'] === 'iTunes') {
                            $itunes = new Uri(trim($link['url']));
                            continue;
                        }

                        if ($link['vendor'] === 'Amazon') {
                            $amazon = new Uri(trim($link['url']));
                            continue;
                        }
                    } catch (\Throwable $e) {
                        continue;
                    }
                }

                try {
                    $image = $this->downloadImage($artist['thumbnailUrl']);
                } catch (\Throwable $e) {
                    $image = null;
                }

                $permalink = strtolower('/' . $artist['urlSafeName']);

                if ($permalink === '/search') {
                    $permalink .= '-official';
                }

                $result = $this->insertArtistCommand->execute(
                    $artist['name'],
                    $artist['urlSafeName'],
                    $officialWebsite,
                    $twitter,
                    $facebook,
                    $itunes,
                    $amazon,
                    $permalink,
                    $image
                );
                
                if (!$result) {
                    throw new \Exception('Inserting artist failed');
                }

            } catch (\Exception $e) {
                $this->getLogger()->critical($e);
            }
        }

        private function downloadImage(string $uri): string
        {
            $handle = fopen($uri, 'rb');
            $image = new Imagick;
            $image->readImageFile($handle);

            $width = $image->getImageWidth();
            $height = $image->getImageHeight();

            $maxSize = 200;

            if ($height > $width) {
                $scalingFactor = $maxSize / $width;
                $newWidth = $maxSize;
                $newHeight = $height * $scalingFactor;
            } else {
                $scalingFactor = $maxSize / $height;
                $newHeight = $maxSize;
                $newWidth = $width * $scalingFactor;
            }

            $splitUri = explode('/', $uri);
            $sliced  = array_slice($splitUri, -1);
            $filename = array_pop($sliced);
            $image->resizeImage($newWidth, $newHeight, Imagick::FILTER_LANCZOS, 1);
            $image->writeImage('/var/www/CDN/artists/' . $filename);
            $image->clear();

            return $filename;
        }
    }
}

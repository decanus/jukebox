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
    use Jukebox\Framework\ValueObjects\WebProfiles\Amazon;
    use Jukebox\Framework\ValueObjects\WebProfiles\iTunes;
    use Jukebox\Framework\ValueObjects\WebProfiles\OfficialWebsite;
    use Jukebox\Framework\ValueObjects\WebProfiles\Twitter;

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
                $webProfiles = $this->handleWebProfiles($artist['links'], $artist['buyLinks']);

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
                    $permalink,
                    $image,
                    $webProfiles
                );
                
                if (!$result) {
                    throw new \Exception('Inserting artist failed');
                }

            } catch (\Exception $e) {
                $this->getLogger()->critical($e);
            }
        }

        private function handleWebProfiles(array $links = [], array $buyLinks = []): array
        {
            $profiles = [];

            foreach ($links as $link) {
                try {
                    $type = $link['type'];

                    if ($type === 'Twitter') {
                        $profiles[] = ['profile' => new Twitter, 'profileData' => trim($link['userName'])];
                        continue;
                    }

                    if ($link['type'] === 'Official Website') {
                        $profiles[] = ['profile' => new OfficialWebsite, 'profileData' => trim($link['url'])];
                        continue;
                    }

                    if ($type === 'Facebook') {
                        continue;
                    }
                } catch (\Throwable $e) {
                    continue;
                }
            }

            foreach ($buyLinks as $buyLink) {
                $vendor = $buyLink['vendor'];

                if ($vendor === 'iTunes') {
                    $profiles[] = ['profile' => new iTunes, 'profileData' => trim($buyLink['url'])];
                    continue;
                }

                if ($vendor === 'Amazon') {
                    $profiles[] = ['profile' => new Amazon, 'profileData' => trim($buyLink['url'])];
                }
            }

            return $profiles;
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

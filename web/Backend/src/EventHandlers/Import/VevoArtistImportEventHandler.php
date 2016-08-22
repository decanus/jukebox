<?php

namespace Jukebox\Backend\EventHandlers\Import
{

    use Jukebox\Backend\Commands\InsertArtistCommand;
    use Jukebox\Backend\Events\VevoArtistImportEvent;
    use Jukebox\Backend\Queries\FetchArtistByVevoIdQuery;
    use Jukebox\Backend\Services\Vevo;
    use Jukebox\Framework\Logging\LoggerAware;
    use Jukebox\Framework\Logging\LoggerAwareTrait;
    use Jukebox\Framework\ValueObjects\Uri;
    use Jukebox\Framework\ValueObjects\WebProfiles\Amazon;
    use Jukebox\Framework\ValueObjects\WebProfiles\Facebook;
    use Jukebox\Framework\ValueObjects\WebProfiles\iTunes;
    use Jukebox\Framework\ValueObjects\WebProfiles\OfficialWebsite;
    use Jukebox\Framework\ValueObjects\WebProfiles\Twitter;

    class VevoArtistImportEventHandler extends AbstractArtistImportEventHandler implements LoggerAware
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

                    if ($type === 'Official Website') {
                        $uri = new Uri(trim($link['url']));
                        if ($uri->getHost() === 'facebook.com' || $uri->getHost() === 'www.facebook.com') {
                            $type = 'Facebook';
                        } else {
                            $profiles[] = ['profile' => new OfficialWebsite, 'profileData' => (string) $uri];
                            continue;
                        }
                    }

                    if ($type === 'Facebook') {
                        $profiles[] = ['profile' => new Facebook, 'profileData' => trim($link['url'])];
                        continue;
                    }
                } catch (\Throwable $e) {
                    continue;
                }
            }

            foreach ($buyLinks as $buyLink) {
                $vendor = $buyLink['vendor'];

                if ($vendor === 'iTunes') {
                    $uri = new Uri(trim($buyLink['url']));
                    foreach ($profiles as $profile) {
                        $data = new Uri($profile['profileData']);
                        if ($data->getPath() === $uri->getPath()) {
                            continue 2;
                        }
                    }

                    $profiles[] = ['profile' => new iTunes, 'profileData' => (string) $uri];
                    continue;
                }

                if ($vendor === 'Amazon') {
                    $profiles[] = ['profile' => new Amazon, 'profileData' => trim($buyLink['url'])];
                }
            }

            return $profiles;
        }

    }
}

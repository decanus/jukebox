<?php

namespace Jukebox\Backend\EventHandlers\Import
{

    use Jukebox\Backend\Commands\InsertArtistCommand;
    use Jukebox\Backend\Events\SoundcloudArtistImportEvent;
    use Jukebox\Backend\Services\Soundcloud;
    use Jukebox\Framework\Logging\LoggerAware;
    use Jukebox\Framework\Logging\LoggerAwareTrait;
    use Jukebox\Framework\ValueObjects\WebProfiles\Facebook;
    use Jukebox\Framework\ValueObjects\WebProfiles\Twitter;

    class SoundcloudArtistImportEventHandler extends AbstractArtistImportEventHandler implements LoggerAware
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

                $profiles = [];

                foreach ($webProfiles as $webProfile) {
                    if (isset($webProfile['service']) && $webProfile['service'] === 'facebook') {
                        $profiles[] = ['profile' => new Facebook, 'profileData' => $webProfile['url']];
                        continue;
                    }

                    if (isset($webProfile['service']) && $webProfile['service'] === 'twitter') {
                        $profiles[] = ['profile' => new Twitter, 'profileData' => $webProfile['username']];

                    }
                }

                $permalink = $permalink = preg_replace('/[^A-Za-z0-9 \- \/ ]/', '', strtolower('/' . $artist['username']));
                $permalink = str_replace(' ', '-', $permalink);
                $avatarUrl = str_replace('-large', '-t200x200', $artist['avatar_url']);

                try {
                    $image = $this->downloadImage($avatarUrl);
                } catch (\Throwable $e) {
                    $image = null;
                }

                // @todo not sure if we should use username
                $this->insertArtistCommand->execute(
                    $artist['username'],
                    null,
                    $permalink,
                    $image,
                    $id,
                    $profiles
                );

            } catch (\Throwable $e) {
                $this->getLogger()->critical($e);
            }
        }
    }
}

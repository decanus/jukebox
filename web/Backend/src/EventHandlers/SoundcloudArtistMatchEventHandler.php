<?php

namespace Jukebox\Backend\EventHandlers
{

    use Jukebox\Backend\Commands\UpdateArtistSoundcloudIdCommand;
    use Jukebox\Backend\Events\SoundcloudArtistMatchEvent;
    use Jukebox\Backend\Queries\FetchArtistByIdQuery;
    use Jukebox\Backend\Services\Soundcloud;
    use Jukebox\Framework\Logging\LoggerAware;
    use Jukebox\Framework\Logging\LoggerAwareTrait;
    use Jukebox\Framework\ValueObjects\Uri;

    class SoundcloudArtistMatchEventHandler implements EventHandlerInterface, LoggerAware
    {
        use LoggerAwareTrait;

        /**
         * @var SoundcloudArtistMatchEvent
         */
        private $event;

        /**
         * @var FetchArtistByIdQuery
         */
        private $fetchArtistByIdQuery;

        /**
         * @var Soundcloud
         */
        private $soundcloud;

        /**
         * @var UpdateArtistSoundcloudIdCommand
         */
        private $updateArtistSoundcloudIdCommand;

        public function __construct(
            SoundcloudArtistMatchEvent $event,
            FetchArtistByIdQuery $fetchArtistByIdQuery,
            Soundcloud $soundcloud,
            UpdateArtistSoundcloudIdCommand $updateArtistSoundcloudIdCommand
        )
        {
            $this->event = $event;
            $this->fetchArtistByIdQuery = $fetchArtistByIdQuery;
            $this->soundcloud = $soundcloud;
            $this->updateArtistSoundcloudIdCommand = $updateArtistSoundcloudIdCommand;
        }

        public function execute()
        {
            try {

                $artistId = $this->event->getArtistId();
                $artist = $this->fetchArtistByIdQuery->execute($artistId);

                if ($artist['official_website'] === null) {
                    return;
                }

                $results = $this->soundcloud->searchForArtist($artist['name'])->getDecodedJsonResponse();

                foreach ($results as $result) {
                    if ($result['website'] === null) {
                        continue;
                    }

                    // @todo test facebook and twitter paths
                    if (strpos($result['website'], 'facebook') !== false) {
                        continue;
                    }

                    if (strpos($result['website'], 'twitter') !== false) {
                        continue;
                    }

                    if (!isset($result['subscriptions'][0])) {
                        continue;
                    }

                    if ($result['subscriptions'][0]['product']['id'] !== 'creator-pro-unlimited') {
                        continue;
                    }

                    similar_text(str_replace(['www.', '/'], '', $result['website']), str_replace(['www.', '/'], '', $artist['official_website']), $websiteSimilarity);
                    if ($websiteSimilarity === 100) {
                        $this->updateArtistSoundcloudIdCommand->execute($artistId, $result['id']);
                        return;
                    }

                    similar_text($result['website'], $artist['official_website'], $websiteSimilarity);
                    similar_text(strtolower($result['username']), strtolower($artist['name']), $nameMatch);

                    if (($websiteSimilarity + $nameMatch) / 2 >= 90) {
                        $this->updateArtistSoundcloudIdCommand->execute($artistId, $result['id']);
                        return;
                    }

                    similar_text(strtolower($result['username']), strtolower($artist['name'] . 'music'), $extendedNameMatch);
                    if (($websiteSimilarity + $extendedNameMatch) / 2 >= 90) {
                        $this->updateArtistSoundcloudIdCommand->execute($artistId, $result['id']);
                        return;
                    }
                }
            } catch (\Throwable $e) {
                $this->getLogger()->critical($e);
            }
        }
    }
}

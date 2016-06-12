<?php

namespace Jukebox\Backend\EventHandlers
{

    use Jukebox\Backend\Commands\UpdateArtistSoundcloudIdCommand;
    use Jukebox\Backend\Events\SoundcloudArtistMatchEvent;
    use Jukebox\Backend\Queries\FetchArtistByIdQuery;
    use Jukebox\Backend\Services\Soundcloud;
    use Jukebox\Framework\Logging\LoggerAware;
    use Jukebox\Framework\Logging\LoggerAwareTrait;

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

                $results = $this->soundcloud->searchForArtist($artist['name']);

                foreach ($results as $result) {
                    if ($result['website'] !== $artist['official_website']) {
                        continue;
                    }

                    $this->updateArtistSoundcloudIdCommand->execute($artistId, $result['id']);
                }

            } catch (\Throwable $e) {
                $this->getLogger()->critical($e);
            }
        }
    }
}

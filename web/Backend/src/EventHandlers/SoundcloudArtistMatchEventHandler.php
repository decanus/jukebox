<?php

namespace Jukebox\Backend\EventHandlers
{

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

        public function __construct(
            SoundcloudArtistMatchEvent $event,
            FetchArtistByIdQuery $fetchArtistByIdQuery,
            Soundcloud $soundcloud
        )
        {
            $this->event = $event;
            $this->fetchArtistByIdQuery = $fetchArtistByIdQuery;
            $this->soundcloud = $soundcloud;
        }

        public function execute()
        {
            try {

                $artistId = $this->event->getArtistId();
                $artist = $this->fetchArtistByIdQuery->execute($artistId);

                $results = $this->soundcloud->searchForArtist($artist['name']);

                foreach ($results as $result) {
                    if ($result['website'] === $artist['official_website']) {
                        // @todo: add soundcloud id
                    }
                }

            } catch (\Throwable $e) {
                $this->getLogger()->critical($e);
            }
        }
    }
}

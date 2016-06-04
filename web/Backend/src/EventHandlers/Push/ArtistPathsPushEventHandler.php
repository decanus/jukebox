<?php

namespace Jukebox\Backend\EventHandlers\Push
{

    use Jukebox\Backend\EventHandlers\EventHandlerInterface;
    use Jukebox\Backend\Queries\FetchArtistPathsQuery;
    use Jukebox\Framework\DataPool\DataPoolWriter;

    class ArtistPathsPushEventHandler implements EventHandlerInterface
    {
        /**
         * @var FetchArtistPathsQuery
         */
        private $fetchArtistPathsQuery;

        /**
         * @var DataPoolWriter
         */
        private $writer;

        public function __construct(FetchArtistPathsQuery $fetchArtistPathsQuery, DataPoolWriter $writer)
        {
            $this->writer = $writer;
            $this->fetchArtistPathsQuery = $fetchArtistPathsQuery;
        }

        public function execute()
        {
            $tracks = $this->fetchArtistPathsQuery->execute();

            foreach ($tracks as $track) {
                $this->writer->setArtistIdForPath($track['permalink'], $track['id']);
            }
        }
    }
}

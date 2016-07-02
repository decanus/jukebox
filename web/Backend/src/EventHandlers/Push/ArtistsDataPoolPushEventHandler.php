<?php

namespace Jukebox\Backend\EventHandlers\Push
{

    use Jukebox\Backend\EventHandlers\EventHandlerInterface;
    use Jukebox\Backend\Queries\FetchArtistsQuery;
    use Jukebox\Framework\DataPool\DataPoolWriter;

    class ArtistsDataPoolPushEventHandler implements EventHandlerInterface
    {
        /**
         * @var DataPoolWriter
         */
        private $dataPoolWriter;

        /**
         * @var FetchArtistsQuery
         */
        private $fetchArtistsQuery;

        public function __construct(DataPoolWriter $dataPoolWriter, FetchArtistsQuery $fetchArtistsQuery)
        {
            $this->dataPoolWriter = $dataPoolWriter;
            $this->fetchArtistsQuery = $fetchArtistsQuery;
        }

        public function execute()
        {
            $artists = $this->fetchArtistsQuery->execute();

            foreach ($artists as $artist) {
                $artist['type'] = 'artists';
                $this->dataPoolWriter->setArtist($artist['id'], $artist);
            }
        }
    }
}

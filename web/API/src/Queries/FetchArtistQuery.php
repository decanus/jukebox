<?php

namespace Jukebox\API\Queries
{

    use Jukebox\API\Backends\SearchBackend;
    use Jukebox\Framework\DataPool\DataPoolReader;

    class FetchArtistQuery
    {
        /**
         * @var DataPoolReader
         */
        private $dataPoolReader;

        public function __construct(DataPoolReader $dataPoolReader)
        {
            $this->dataPoolReader = $dataPoolReader;
        }

        public function execute(string $id)
        {
            return $this->dataPoolReader->getArtist($id);
        }
    }
}

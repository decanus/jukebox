<?php

namespace Jukebox\API\Queries
{

    use Jukebox\Framework\DataPool\DataPoolReader;

    class FetchTrackByIdQuery
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
            return $this->dataPoolReader->getTrack($id);
        }
    }
}

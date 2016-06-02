<?php

namespace Jukebox\API\Factories
{

    use Jukebox\Framework\ValueObjects\DataVersion;

    class BackendFactory extends \Jukebox\Framework\Factories\BackendFactory
    {
        /**
         * @var DataVersion
         */
        private $dataVersion;

        public function __construct(DataVersion $dataVersion)
        {
            $this->dataVersion = $dataVersion;
        }
        
        public function createSearchBackend(): \Jukebox\API\Backends\SearchBackend
        {
            return new \Jukebox\API\Backends\SearchBackend(
                $this->dataVersion,
                $this->getMasterFactory()->createElasticsearchClient(),
                $this->getMasterFactory()->createSearchResultMapper()
            );
        }
    }
}

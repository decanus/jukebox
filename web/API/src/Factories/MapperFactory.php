<?php

namespace Jukebox\API\Factories
{

    use Jukebox\Framework\Factories\AbstractFactory;

    class MapperFactory extends AbstractFactory
    {
        public function createSearchResultMapper(): \Jukebox\API\Mappers\SearchResultMapper
        {
            return new \Jukebox\API\Mappers\SearchResultMapper(
                $this->getMasterFactory()->createDataPoolReader()
            );
        }
    }
}

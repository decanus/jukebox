<?php

namespace Jukebox\Frontend\Models
{

    use Jukebox\Framework\Models\AbstractModel;

    class SearchPageModel extends AbstractModel
    {
        private $results;

        public function setSearchResults(array $results)
        {
            $this->results = $results;
        }

        public function getSearchResults(): array
        {
            return $this->results;
        }
    }
}

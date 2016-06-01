<?php

namespace Jukebox\Backend\Events
{

    use Jukebox\Framework\Events\EventInterface;
    use Jukebox\Framework\ValueObjects\DataVersion;

    class TracksToElasticsearchPushEvent implements EventInterface
    {
        private $dataVersion;

        public function __construct(DataVersion $dataVersion)
        {
            $this->dataVersion = $dataVersion;
        }

        public function getName(): string
        {
            return 'TracksToElasticsearchPush';
        }

        public function getDataVersion(): DataVersion
        {
            return $this->dataVersion;
        }
    }
}

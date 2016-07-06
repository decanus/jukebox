<?php

namespace Jukebox\Backend\Events
{

    use Jukebox\Framework\Events\EventInterface;
    use Jukebox\Framework\ValueObjects\DataVersion;

    class InitialTrackDataPoolPushEvent implements EventInterface
    {
        /**
         * @var DataVersion
         */
        private $dataVersion;

        public function __construct(DataVersion $dataVersion)
        {
            $this->dataVersion = $dataVersion;
        }

        public function getName(): string
        {
            return 'InitialTrackDataPoolPush';
        }

        public function getDataVersion(): DataVersion
        {
            return $this->dataVersion;
        }
    }
}

<?php

namespace Jukebox\Backend\Events
{

    use Jukebox\Framework\Events\EventInterface;
    use Jukebox\Framework\ValueObjects\DataVersion;

    class SwitchElasticsearchIndexEvent implements EventInterface
    {
        /**
         * @var DataVersion
         */
        private $dataVersion;

        /**
         * @var DataVersion
         */
        private $oldDataVersion;

        public function __construct(DataVersion $dataVersion, DataVersion $oldDataVersion)
        {
            $this->dataVersion = $dataVersion;
            $this->oldDataVersion = $oldDataVersion;
        }

        public function getName(): string
        {
            return 'SwitchElasticsearchIndex';
        }

        public function getOldDataVersion(): DataVersion
        {
            return $this->oldDataVersion;
        }

        public function getDataVersion(): DataVersion
        {
            return $this->dataVersion;
        }
    }
}

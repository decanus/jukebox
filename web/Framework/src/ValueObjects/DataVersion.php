<?php

namespace Jukebox\Framework\ValueObjects
{
    class DataVersion
    {
        private $version;

        public function __construct(string $version)
        {
            $this->setVersion($version);
        }

        private function setVersion(string $version)
        {
            if ($version == 'now') {
                $version = new \DateTime();
                $version = $version->format('Ymd-Hi');
            }

            if (\DateTime::createFromFormat('Ymd-Hi', $version) === false) {
                throw new \InvalidArgumentException('Invalid version format "' . $version . '"');
            }

            $this->version = $version;
        }

        public function __toString(): string
        {
            return (string) $this->version;
        }
    }
}

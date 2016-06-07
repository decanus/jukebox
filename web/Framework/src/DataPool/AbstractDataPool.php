<?php

namespace Jukebox\Framework\DataPool
{

    use Jukebox\Framework\ValueObjects\DataVersion;

    abstract class AbstractDataPool
    {
        /**
         * @var DataPoolKeyGenerator
         */
        private $dataPoolKeyGenerator;

        /**
         * @var StorageBackendInterface
         */
        private $storageBackend;

        /**
         * @var DataVersion
         */
        private $dataVersion = null;

        public function __construct(
            DataPoolKeyGenerator $dataPoolKeyGenerator,
            StorageBackendInterface $storageBackend,
            DataVersion $dataVersion = null
        )
        {
            $this->dataPoolKeyGenerator = $dataPoolKeyGenerator;
            $this->storageBackend = $storageBackend;
            $this->dataVersion = $dataVersion;
        }

        protected function has(string $key): bool
        {
            return $this->getBackend()->has($key);
        }

        protected function get(string $key): string
        {
            return $this->getBackend()->get($key);
        }

        protected function set(string $key, string $value)
        {
            $this->getBackend()->set($key, $value);
        }

        protected function hhas(string $key, string $hashKey): bool
        {
            return $this->getBackend()->hhas($key, $hashKey);
        }

        protected function hset(string $key, string $hashKey, string $value)
        {
            return $this->getBackend()->hset($key, $hashKey, $value);
        }

        protected function hmset(string $key, array $hashKeys)
        {
            return $this->getBackend()->hmset($key, $hashKeys);
        }

        protected function hget(string $key, string $hashKey): string
        {
            return $this->getBackend()->hget($key, $hashKey);
        }

        protected function getKeyGenerator(): DataPoolKeyGenerator
        {
            return $this->dataPoolKeyGenerator;
        }

        protected function getBackend(): StorageBackendInterface
        {
            return $this->storageBackend;
        }

        protected function getVersion(): DataVersion
        {
            if ($this->dataVersion === null) {
                $this->dataVersion = new DataVersion($this->getBackend()->get('currentDataVersion'));
            }

            return $this->dataVersion;
        }
    }
}

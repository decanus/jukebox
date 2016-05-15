<?php

namespace Jukebox\Framework\Http\Request
{

    use Jukebox\Framework\ValueObjects\UploadedFile;

    class PostRequest extends AbstractRequest
    {
        /**
         * @var array
         */
        private $files;

        /**
         * @param array $parameters
         * @param array $server
         * @param array $cookies
         * @param array $files
         */
        public function __construct($parameters = [], $server = [], $cookies = [], $files = [])
        {
            parent::__construct($parameters, $server, $cookies);
            $this->files = $files;
        }

        /**
         * @return bool
         */
        public function hasFiles(): bool
        {
            return !empty($this->files);
        }

        /**
         * @return array
         */
        public function getFiles(): array
        {
            return $this->files;
        }

        /**
         * @param string $name
         *
         * @return bool
         */
        public function hasFile($name): bool
        {
            return isset($this->files[$name]) && $this->files[$name]['error'] === 0;
        }

        /**
         * @param string $name
         *
         * @return UploadedFile
         * @throws \InvalidArgumentException
         */
        public function getFile($name): UploadedFile
        {
            if (!$this->hasFile($name)) {
                throw new \InvalidArgumentException('File "' . $name . '" does not exist');
            }

            return new UploadedFile($this->files[$name]);
        }

        /**
         * @return array
         * @throws \Exception
         */
        public function getFileNames(): array
        {
            if (!$this->hasFiles()) {
                throw new \Exception('Request has no files');
            }

            return array_keys($this->getFiles());
        }
    }
}

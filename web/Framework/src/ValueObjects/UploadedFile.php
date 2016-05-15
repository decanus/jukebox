<?php

namespace Jukebox\Framework\ValueObjects
{
    class UploadedFile
    {
        /**
         * @var array
         */
        private $file;

        /**
         * @param array $file
         */
        public function __construct(array $file)
        {
            if ($this->file['error'] > 0) {
                throw new \RuntimeException('Error "' . $this->file['error'] . '" occurred while uploading the file');
            }
            if (!is_uploaded_file($file['tmp_name'])) {
                throw new \RuntimeException('The file "' . $file['tmp_name'] . '" was not uploaded. Access denied');
            }
            $this->file = $file;
        }

        /**
         * @return string
         */
        public function getName(): string
        {
            return $this->file['name'];
        }

        /**
         * @return string
         */
        public function getMimeType(): string
        {
            return $this->file['type'];
        }
    }
}

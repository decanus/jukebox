<?php

namespace Park\Framework
{
    class Configuration
    {
        /**
         * @var string
         */
        private $file;

        /**
         * @var bool
         */
        private $isLoaded;

        public function __construct(string $file)
        {
            $this->file = $file;
        }

        public function get(string $key): string
        {
            $this->load();
            if (!isset($this->file[$key])) {
                throw new \Exception('Configuration key "' . $key . '" does not exist');
            }
            return $this->file[$key];
        }

        public function isDevelopmentMode(): bool
        {
            return $this->get('isDevelopmentMode') == 'true';
        }

        private function load()
        {
            if ($this->isLoaded) {
                return;
            }

            if (!is_readable($this->file)) {
                throw new \Exception('Configuration file "' . $this->file . '" is not readable');
            }

            $this->isLoaded = true;
            $this->file = parse_ini_file($this->file);
        }
    }
}

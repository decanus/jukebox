<?php

namespace Jukebox\Backend\CLI
{
    class Request
    {
        /**
         * @var string
         */
        private $action;

        /**
         * @var array
         */
        private $params = array();

        public function __construct(string $action, array $params)
        {
            $this->action = $action;
            $this->params = $params;
        }
        /**
         * @return string
         */
        public function getAction()
        {
            return $this->action;
        }

        public function getParam(string $key)
        {
            if (!$this->hasParam($key)) {
                throw new \Exception('Parameter "' . $key . '" not set');
            }
            return $this->params[$key];
        }

        public function getParams(): array
        {
            return $this->params;
        }

        public function hasParam(string $key): bool
        {
            return isset($this->params[$key]) && !empty($this->params[$key]);
        }
    }
}

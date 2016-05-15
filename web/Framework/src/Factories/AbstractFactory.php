<?php

namespace Jukebox\Framework\Factories
{
    class AbstractFactory
    {
        /**
         * @var MasterFactory
         */
        private $masterFactory;

        public function register(MasterFactory $masterFactory)
        {
            $this->masterFactory = $masterFactory;
        }

        protected function getMasterFactory(): MasterFactory
        {
            return $this->masterFactory;
        }
    }
}

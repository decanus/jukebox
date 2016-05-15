<?php

namespace Jukebox\Framework
{

    use Jukebox\Framework\Bootstrap\AbstractBootstrapper;
    use Jukebox\Framework\Http\Response\AbstractResponse;

    class FrontController
    {
        /**
         * @var AbstractBootstrapper
         */
        private $bootstrapper;

        public function __construct(AbstractBootstrapper $bootstrapper)
        {
            $this->bootstrapper = $bootstrapper;
        }

        public function run(): AbstractResponse
        {
            $request = $this->bootstrapper->getRequest();
            return $this->bootstrapper->getRouter()->route($request)->execute($request);
        }
    }
}

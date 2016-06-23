<?php

namespace Jukebox\Framework\Bootstrap
{

    use Jukebox\Framework\Configuration;
    use Jukebox\Framework\Factories\MasterFactory;
    use Jukebox\Framework\Http\Request\AbstractRequest;
    use Jukebox\Framework\Http\Request\GetRequest;
    use Jukebox\Framework\Http\Request\PostRequest;
    use Jukebox\Framework\Routers\RouterInterface;

    abstract class AbstractBootstrapper
    {
        /**
         * @var AbstractRequest
         */
        private $request;

        /**
         * @var MasterFactory
         */
        private $factory;

        /**
         * @var RouterInterface
         */
        private $router;

        public function __construct()
        {
            $this->bootstrap();
        }

        /**
         * @return AbstractRequest
         */
        public function getRequest()
        {
            return $this->request;
        }

        public function getRouter(): RouterInterface
        {
            return $this->router;
        }

        public function getFactory(): MasterFactory
        {
            return $this->factory;
        }

        /**
         * @return AbstractRequest
         */
        protected function buildRequest()
        {
            if (!isset($_SERVER['REQUEST_METHOD'])) {
                throw new \InvalidArgumentException('Missing REQUEST_METHOD in $_SERVER');
            }
            
            $requestMethod = $_SERVER['REQUEST_METHOD'];
            switch ($requestMethod) {
                case 'GET':
                    return new GetRequest($_GET, $_SERVER, $_COOKIE);
                case 'POST':
                    return new PostRequest($_POST, $_SERVER, $_COOKIE, $_FILES);
                default:
                    throw new \InvalidArgumentException('Unsupported request method "' . $requestMethod . '"');
            }
        }

        private function bootstrap()
        {
            $this->request = $this->buildRequest();
            $this->doBootstrap();
            $this->factory = $this->buildFactory();
            $this->registerErrorHandler();
            $this->router  = $this->buildRouter();
        }

        abstract protected function doBootstrap();

        abstract protected function buildFactory(): MasterFactory;

        abstract protected function buildRouter();

        abstract protected function getConfiguration(): Configuration;

        abstract protected function registerErrorHandler();
    }
}

<?php

namespace Jukebox\Backend\Bootstrapper
{

    use Jukebox\Backend\CLI\ParameterParser;
    use Jukebox\Backend\CLI\Request;
    use Jukebox\Framework\Bootstrap\AbstractBootstrapper;
    use Jukebox\Framework\Configuration;
    use Jukebox\Framework\ErrorHandlers\DevelopmentErrorHandler;
    use Jukebox\Framework\ErrorHandlers\ProductionErrorHandler;
    use Jukebox\Framework\Factories\MasterFactory;

    class WriterBootstrapper extends AbstractBootstrapper
    {
        /**
         * @var Configuration
         */
        private $configuration;

        /**
         * @var array
         */
        private $argv;

        /**
         * @var Request
         */
        private $request;

        /**
         * @param array $argv
         */
        public function __construct(array $argv)
        {
            $this->argv = $argv;
            parent::__construct();
        }

        protected function doBootstrap()
        {
            // TODO: Implement doBootstrap() method.
        }

        protected function buildFactory(): MasterFactory
        {
            $factory = new MasterFactory($this->getConfiguration());

            $factory->addFactory(new \Jukebox\Backend\Factories\ApplicationFactory);
            $factory->addFactory(new \Jukebox\Framework\Factories\BackendFactory);
            $factory->addFactory(new \Jukebox\Backend\Factories\EventHandlerFactory);
            $factory->addFactory(new \Jukebox\Backend\Factories\LocatorFactory);
            $factory->addFactory(new \Jukebox\Backend\Factories\WriterFactory);
            $factory->addFactory(new \Jukebox\Backend\Factories\LoggerFactory);
            $factory->addFactory(new \Jukebox\Backend\Factories\CommandFactory);

            return $factory;
        }

        protected function buildRouter()
        {
            // TODO: Implement buildRouter() method.
        }

        protected function getConfiguration(): Configuration
        {
            if ($this->configuration === null) {
                $this->configuration =  new Configuration(__DIR__ . '/../../config/system.ini');
            }
            return $this->configuration;
        }

        protected function registerErrorHandler()
        {
            if ($this->isDevelopmentMode()) {
                $errorHandler = new DevelopmentErrorHandler;
            } else {
                $errorHandler = new ProductionErrorHandler;
            }

            $errorHandler->register();
        }

        /**
         * @return Request
         */
        public function getRequest()
        {
            return $this->request;
        }

        protected function buildRequest()
        {
            $action = '';
            if (isset($this->argv[1])) {
                $action = $this->argv[1];
            }
            
            $parser = new ParameterParser;
            $this->request = new Request($action, $parser->parse($this->argv));
        }


        /**
         * @return bool
         */
        private function isDevelopmentMode(): bool
        {
            return $this->getConfiguration()->isDevelopmentMode();
        }
    }
}

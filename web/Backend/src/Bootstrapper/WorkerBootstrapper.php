<?php

namespace Jukebox\Backend\Bootstrapper
{

    use Jukebox\Framework\Bootstrap\AbstractBootstrapper;
    use Jukebox\Framework\Configuration;
    use Jukebox\Framework\ErrorHandlers\DevelopmentErrorHandler;
    use Jukebox\Framework\ErrorHandlers\ProductionErrorHandler;
    use Jukebox\Framework\Factories\MasterFactory;

    class WorkerBootstrapper extends AbstractBootstrapper
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
            $factory->addFactory(new \Jukebox\Backend\Factories\ReaderFactory);
            $factory->addFactory(new \Jukebox\Backend\Factories\LoggerFactory);
            $factory->addFactory(new \Jukebox\Backend\Factories\ServiceFactory);
            $factory->addFactory(new \Jukebox\Backend\Factories\CommandFactory);
            $factory->addFactory(new \Jukebox\Backend\Factories\QueryFactory);

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
         * @return bool
         */
        private function isDevelopmentMode(): bool
        {
            return $this->getConfiguration()->isDevelopmentMode();
        }

        protected function buildRequest()
        {
            return;
        }
    }
}

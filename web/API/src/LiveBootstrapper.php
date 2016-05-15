<?php

namespace Jukebox\API
{

    use Jukebox\Framework\Bootstrap\AbstractBootstrapper;
    use Jukebox\Framework\Configuration;
    use Jukebox\Framework\ErrorHandlers\DevelopmentErrorHandler;
    use Jukebox\API\ErrorHandlers\ProductionErrorHandler;
    use Jukebox\Framework\Factories\MasterFactory;
    use Jukebox\API\Routers\Router;

    class LiveBootstrapper extends AbstractBootstrapper
    {
        /**
         * @var Configuration
         */
        private $configuration;

        protected function doBootstrap()
        {
            // TODO: Implement doBootstrap() method.
        }

        protected function buildFactory(): MasterFactory
        {
            $factory = new MasterFactory($this->getConfiguration());

            $factory->addFactory(new \Jukebox\API\Factories\RouterFactory);
            $factory->addFactory(new \Jukebox\API\Factories\ControllerFactory);
            $factory->addFactory(new \Jukebox\API\Factories\HandlerFactory);
            $factory->addFactory(new \Jukebox\Framework\Factories\LoggerFactory);
            $factory->addFactory(new \Jukebox\Framework\Factories\BackendFactory);
            $factory->addFactory(new \Jukebox\API\Factories\ApplicationFactory);

            return $factory;
        }

        protected function buildRouter()
        {
            $router = new Router($this->getFactory()->createAccessControl());

            $router->addRouter($this->getFactory()->createIndexRouter());
            $router->addRouter($this->getFactory()->createGetRequestRouter());
            $router->addRouter($this->getFactory()->createErrorRouter());

            return $router;
        }

        protected function getConfiguration(): Configuration
        {
            if ($this->configuration === null) {
                $this->configuration = new Configuration(__DIR__ . '/../config/system.ini');
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
    }
}

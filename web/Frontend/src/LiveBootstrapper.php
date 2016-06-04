<?php

namespace Jukebox\Frontend
{

    use Jukebox\Framework\Backends\Streams\TemplatesStreamWrapper;
    use Jukebox\Framework\Bootstrap\AbstractBootstrapper;
    use Jukebox\Framework\Configuration;
    use Jukebox\Framework\ErrorHandlers\DevelopmentErrorHandler;
    use Jukebox\Framework\ErrorHandlers\ProductionErrorHandler;
    use Jukebox\Framework\Factories\MasterFactory;
    use Jukebox\Framework\Routers\Router;

    class LiveBootstrapper extends AbstractBootstrapper
    {
        private $configuration;

        protected function doBootstrap()
        {
            $this->registerStreams();
        }

        protected function buildFactory(): MasterFactory
        {
            $factory = new MasterFactory($this->getConfiguration());
            
            $factory->addFactory(new \Jukebox\Framework\Factories\ApplicationFactory);
            $factory->addFactory(new \Jukebox\Framework\Factories\LoggerFactory);
            $factory->addFactory(new \Jukebox\Framework\Factories\BackendFactory);
            $factory->addFactory(new \Jukebox\Frontend\Factories\RouterFactory);
            $factory->addFactory(new \Jukebox\Frontend\Factories\ControllerFactory);
            $factory->addFactory(new \Jukebox\Frontend\Factories\HandlerFactory);
            $factory->addFactory(new \Jukebox\Frontend\Factories\TransformationFactory);

            return $factory;
        }

        private function registerStreams()
        {
            TemplatesStreamWrapper::setUp(__DIR__ . '/../data/templates');
        }

        protected function buildRouter()
        {
            $router = new Router;

            $router->addRouter($this->getFactory()->createTrackPageRouter());
            $router->addRouter($this->getFactory()->createArtistPageRouter());
            $router->addRouter($this->getFactory()->createStaticPageRouter());
            $router->addRouter($this->getFactory()->createErrorPageRouter());

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

        private function isDevelopmentMode(): bool
        {
            return $this->getConfiguration()->isDevelopmentMode();
        }
    }
}

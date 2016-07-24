<?php

namespace Jukebox\Mirror
{

    use Jukebox\Framework\Bootstrap\AbstractBootstrapper;
    use Jukebox\Framework\Configuration;
    use Jukebox\Framework\Factories\MasterFactory;
    use Jukebox\Framework\Routers\Router;

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
            $factory->addFactory(new \Jukebox\Mirror\Factories\RouterFactory);
            return $factory;
        }

        protected function buildRouter()
        {
            $router = new Router;
            $router->addRouter($this->getFactory()->createPageRouter());
            return $router;
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
            // TODO: Implement registerErrorHandler() method.
        }
    }
}

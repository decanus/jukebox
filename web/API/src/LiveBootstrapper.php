<?php

namespace Jukebox\API
{

    use Jukebox\API\ErrorHandlers\ProductionErrorHandler;
    use Jukebox\API\Factories\SessionFactory;
    use Jukebox\API\Routers\MasterRouter;
    use Jukebox\API\Session\Session;
    use Jukebox\API\Session\SessionStore;
    use Jukebox\Framework\Bootstrap\AbstractBootstrapper;
    use Jukebox\Framework\Configuration;
    use Jukebox\Framework\DataPool\RedisBackend;
    use Jukebox\Framework\Factories\MasterFactory;
    use Jukebox\Framework\ValueObjects\DataVersion;

    class LiveBootstrapper extends AbstractBootstrapper
    {
        /**
         * @var Configuration
         */
        private $configuration;

        /**
         * @var Session
         */
        private $session;

        private $sessionFactory;

        protected function doBootstrap()
        {
            $this->buildSession();
        }

        protected function buildFactory(): MasterFactory
        {
            $dataVersion = $this->getDataVersion();

            $factory = new MasterFactory($this->getConfiguration());

            $factory->addFactory(new \Jukebox\API\Factories\RouterFactory);
            $factory->addFactory(new \Jukebox\API\Factories\CommandFactory($this->session->getSessionData()));
            $factory->addFactory(new \Jukebox\API\Factories\ControllerFactory);
            $factory->addFactory(new \Jukebox\API\Factories\HandlerFactory($this->session));
            $factory->addFactory(new \Jukebox\Framework\Factories\LoggerFactory);
            $factory->addFactory(new \Jukebox\API\Factories\BackendFactory($dataVersion));
            $factory->addFactory(new \Jukebox\API\Factories\ApplicationFactory);
            $factory->addFactory(new \Jukebox\API\Factories\QueryFactory);
            $factory->addFactory(new \Jukebox\API\Factories\MapperFactory);
            $factory->addFactory($this->sessionFactory);

            return $factory;
        }

        protected function buildRouter()
        {
            $router = new MasterRouter($this->getFactory());

            $router->addRouter($this->getFactory()->createArtistsRouter());
            $router->addRouter($this->getFactory()->createAuthenticationRouter());
            $router->addRouter($this->getFactory()->createRegistrationRouter());
            $router->addRouter($this->getFactory()->createSearchRouter());
            $router->addRouter($this->getFactory()->createTracksRouter());
            $router->addRouter($this->getFactory()->createMeRouter());
            $router->addRouter($this->getFactory()->createUsersRouter());
            $router->addRouter($this->getFactory()->createBrowseRouter());

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
            $errorHandler = new ProductionErrorHandler;
            $errorHandler->register();
        }

        protected function buildSession()
        {
            $sessionStore = new SessionStore(
                new RedisBackend(
                    new \Redis(),
                    $this->getConfiguration()->get('redisHost'),
                    $this->getConfiguration()->get('redisPort')
                )
            );

            $this->sessionFactory = new SessionFactory($sessionStore);
            $this->session = $this->sessionFactory->createSession();
            $this->session->load($this->getRequest());
        }

        private function getDataVersion(): DataVersion
        {
            $configuration = $this->getConfiguration();

            return new DataVersion((new \Jukebox\Framework\DataPool\RedisBackend(
                new \Redis,
                $configuration->get('redisHost'),
                $configuration->get('redisPort')
            ))->get('currentDataVersion'));
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

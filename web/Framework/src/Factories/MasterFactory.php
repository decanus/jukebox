<?php

namespace Jukebox\Framework\Factories
{

    use Jukebox\Framework\Configuration;

    class MasterFactory
    {
        /**
         * @var AbstractFactory[]
         */
        private $methods = [];
        
        /**
         * @var Configuration
         */
        private $configuration;
        
        /**
         * @param Configuration $configuration
         */
        public function __construct(Configuration $configuration)
        {
            $this->configuration = $configuration;
        }
        
        public function addFactory(AbstractFactory $factory)
        {
            $rfc = new \ReflectionClass($factory);
            $found = false;
            foreach ($rfc->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
                $name = $method->getName();
                if (strpos($name, 'create') === 0) {
                    $this->setMethod($name, $factory);
                    $found = true;
                }
            }
            
            if (!$found) {
                throw new \Exception('Factory "' . get_class($factory) . '" does not have any methods');
            }
            
            $factory->register($this);
        }
        /**
         * @param $name
         * @param $arguments
         *
         * @return mixed
         * @throws \Exception
         */
        public function __call($name, $arguments)
        {
            if (!$this->hasMethod($name)) {
                throw new \Exception('No factory found for "' . $name . '" method');
            }
            $object = call_user_func_array([$this->getMethod($name), $name], $arguments);
            
            if ($object instanceof \Jukebox\Framework\Logging\LoggerAware) {
                $object->setLogger($this->createLoggers());
            }
            return $object;
        }
        
        private function hasMethod(string $name): bool
        {
            return isset($this->methods[$name]);
        }
        
        private function getMethod(string $name): AbstractFactory
        {
            return $this->methods[$name];
        }
        
        private function setMethod(string $name, AbstractFactory $factory)
        {
            $this->methods[$name] = $factory;
        }
        
        public function getConfiguration(): Configuration
        {
            return $this->configuration;
        }
    }
}

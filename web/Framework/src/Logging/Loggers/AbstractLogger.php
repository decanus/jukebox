<?php

namespace Jukebox\Framework\Logging\Loggers
{

    use Jukebox\Framework\Logging\Logs\LogInterface;

    abstract class AbstractLogger implements LoggerInterface
    {
        public function handles(LogInterface $log): bool
        {
            foreach ($this->getTypes() as $type) {
                if ($log instanceof $type) {
                    return true;
                }
            }

            return false;
        }
        
        abstract protected function getTypes(): array;
    }

}

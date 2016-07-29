<?php

namespace Jukebox\Backend\ValueObjects\Sitemap
{
    class Priority
    {
        private $priority;

        public function __construct(float $priority = 1.0)
        {
            if ($priority > 1.0 || $priority < 0.1) {
                throw new \InvalidArgumentException('Priority must be between 1.0 and 0.1');
            }

            $this->priority = $priority;
        }

        public function __toString(): string 
        {
            return (string) $this->priority;
        }
    }
}

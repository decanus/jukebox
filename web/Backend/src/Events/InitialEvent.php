<?php

namespace Jukebox\Backend\Events
{

    use Jukebox\Framework\Events\EventInterface;

    class InitialEvent implements EventInterface
    {

        public function getName(): string
        {
            return 'Initial';
        }
    }
}

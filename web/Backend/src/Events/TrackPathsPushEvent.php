<?php

namespace Jukebox\Backend\Events
{

    use Jukebox\Framework\Events\EventInterface;

    class TrackPathsPushEvent implements EventInterface
    {

        public function getName(): string
        {
            return 'TrackPathsPush';
        }
    }
}

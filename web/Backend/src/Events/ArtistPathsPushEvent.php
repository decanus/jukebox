<?php

namespace Jukebox\Backend\Events
{

    use Jukebox\Framework\Events\EventInterface;

    class ArtistPathsPushEvent implements EventInterface
    {

        public function getName(): string
        {
            return 'ArtistPathsPush';
        }
    }
}

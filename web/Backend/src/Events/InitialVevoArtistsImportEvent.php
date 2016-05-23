<?php

namespace Jukebox\Backend\Events
{

    use Jukebox\Framework\Events\EventInterface;

    class InitialVevoArtistsImportEvent implements EventInterface
    {

        public function getName(): string
        {
            return 'InitialVevoArtistsImport';
        }
    }
}

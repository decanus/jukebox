<?php

namespace Jukebox\Backend\Events
{

    use Jukebox\Framework\Events\EventInterface;

    class InitialVevoArtistsVideosImportEvent implements EventInterface
    {
        public function getName(): string
        {
            return 'InitialVevoArtistsVideosImport';
        }
    }
}

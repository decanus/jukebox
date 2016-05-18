<?php

namespace Jukebox\Backend\Events
{
    use Jukebox\Framework\Events\EventInterface;

    class InitialVevoGenresImportEvent implements EventInterface
    {
        public function getName(): string
        {
            return 'InitialVevoGenresImport';
        }
    }
}

<?php

namespace Jukebox\Backend\Events
{
    use Jukebox\Framework\Events\EventInterface;

    class VevoGenresImportEvent implements EventInterface
    {
        public function getName(): string
        {
            return 'VevoGenresImport';
        }
    }
}

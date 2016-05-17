<?php

namespace Jukebox\Backend\Locators
{

    use Jukebox\Framework\Events\EventInterface;

    class EventLocator
    {
        public function locate(string $event): EventInterface
        {
            switch ($event) {
                case 'InitialVevoArtistsImport':
                    return new \Jukebox\Backend\Events\InitialVevoArtistsImportEvent;
                default:
                    throw new \InvalidArgumentException('Event "' . $event . '" does not exist');
            }
        }
    }
}

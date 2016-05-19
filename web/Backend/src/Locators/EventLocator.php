<?php

namespace Jukebox\Backend\Locators
{

    use Jukebox\Backend\CLI\Request;
    use Jukebox\Framework\Events\EventInterface;

    class EventLocator
    {
        public function locate(Request $request): EventInterface
        {
            switch ($request->getAction()) {
                case 'InitialVevoArtistsImport':
                    return new \Jukebox\Backend\Events\InitialVevoArtistsImportEvent;
                case 'VevoGenresImport':
                    return new \Jukebox\Backend\Events\VevoGenresImportEvent;
                case 'VevoArtistImport':
                    return new \Jukebox\Backend\Events\VevoArtistImportEvent($request->getParam('artist'));
                case 'VevoArtistVideosImport':
                    return new \Jukebox\Backend\Events\VevoArtistVideosImportEvent($request->getParam('artist'));
                default:
                    throw new \InvalidArgumentException('Event "' . $request->getAction() . '" does not exist');
            }
        }
    }
}

<?php

namespace Jukebox\Backend\Locators
{

    use Jukebox\Backend\CLI\Request;
    use Jukebox\Framework\Events\EventInterface;
    use Jukebox\Framework\ValueObjects\DataVersion;

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
                case 'InitialVevoArtistsVideosImport':
                    return new \Jukebox\Backend\Events\InitialVevoArtistsVideosImportEvent;
                case 'ElasticsearchIndexPushEvent':
                    return new \Jukebox\Backend\Events\ElasticsearchIndexPushEvent(new DataVersion($request->getParam('dataVersion')));
                case 'ArtistsToElasticsearchPush':
                    return new \Jukebox\Backend\Events\ArtistsToElasticsearchPushEvent(new DataVersion($request->getParam('dataVersion')));
                default:
                    throw new \InvalidArgumentException('Event "' . $request->getAction() . '" does not exist');
            }
        }
    }
}

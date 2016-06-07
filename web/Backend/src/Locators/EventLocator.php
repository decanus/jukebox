<?php

namespace Jukebox\Backend\Locators
{

    use Jukebox\Backend\CLI\Request;
    use Jukebox\Framework\Events\EventInterface;
    use Jukebox\Framework\ValueObjects\DataVersion;

    class EventLocator
    {
        private $request;

        public function locate(Request $request): EventInterface
        {
            $this->request = $request;

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
                    return new \Jukebox\Backend\Events\ElasticsearchIndexPushEvent($request->getDataVersion());
                case 'ArtistsToElasticsearchPush':
                    return new \Jukebox\Backend\Events\ArtistsToElasticsearchPushEvent($request->getDataVersion());
                case 'TracksToElasticsearchPush':
                    return new \Jukebox\Backend\Events\TracksToElasticsearchPushEvent($request->getDataVersion());
                case 'Initial':
                    return new \Jukebox\Backend\Events\InitialEvent;
                case 'TrackPathsPush':
                    return new \Jukebox\Backend\Events\TrackPathsPushEvent($request->getDataVersion());
                case 'ArtistPathsPush':
                    return new \Jukebox\Backend\Events\ArtistPathsPushEvent($request->getDataVersion());
                default:
                    throw new \InvalidArgumentException('Event "' . $request->getAction() . '" does not exist');
            }
        }
    }
}

<?php

namespace Jukebox\Backend\Locators
{

    use Jukebox\Backend\EventHandlers\EventHandlerInterface;
    use Jukebox\Backend\Factories\EventHandlerFactory;
    use Jukebox\Framework\Events\EventInterface;
    use Jukebox\Framework\Factories\MasterFactory;

    class EventHandlerLocator
    {
        /**
         * @var EventHandlerFactory
         */
        private $factory;

        /**
         * @param MasterFactory $factory
         */
        public function __construct(MasterFactory $factory)
        {
            $this->factory = $factory;
        }

        public function locate(EventInterface $event): EventHandlerInterface
        {
            switch ($event->getName()) {
                case 'InitialVevoArtistsImport':
                    return $this->factory->createInitialVevoArtistsImportEventHandler();
                case 'VevoGenresImport':
                    return $this->factory->createVevoGenresImportEventHandler();
                case 'VevoArtistImport':
                    return $this->factory->createVevoArtistImportEventHandler($event);
                case 'VevoArtistVideosImport':
                    return $this->factory->createVevoArtistVideosImportEventHandler($event);
                case 'InitialVevoArtistsVideosImport':
                    return $this->factory->createInitialVevoArtistsVideosImportEventHandler();
                case 'ElasticsearchIndexPush':
                    return $this->factory->createElasticsearchIndexPushEventHandler($event);
                case 'ArtistsToElasticsearchPush':
                    return $this->factory->createArtistsToElasticsearchPushEventHandler($event);
                case 'TracksToElasticsearchPush':
                    return $this->factory->createTracksToElasticsearchPushEventHandler($event);
                case 'Initial':
                    return $this->factory->createInitialEventHandler();
                case 'DataVersionPush':
                    return $this->factory->createDataVersionPushEventHandler($event);
                case 'TrackPathsPush':
                    return $this->factory->createTrackPathsPushEventHandler($event);
                case 'ArtistPathsPush':
                    return $this->factory->createArtistPathsPushEventHandler($event);
                case 'ElasticsearchIndexDelete':
                    return $this->factory->createElasticsearchIndexDeleteEventHandler($event);
                case 'OldDataVersionDelete':
                    return $this->factory->createOldDataVersionDeleteEventHandler($event);
                case 'SoundcloudTracksImport':
                    return $this->factory->createSoundcloudTracksImportEventHandler($event);
                case 'SoundcloudArtistImport':
                    return $this->factory->createSoundcloudArtistImportEventHandler($event);
                case 'ArtistsDataPoolPush':
                    return $this->factory->createArtistsDataPoolPushEventHandler($event);
                case 'InitialTrackDataPoolPush':
                    return $this->factory->createInitialTrackDataPoolPushEventHandler($event);
                case 'TrackDataPoolPush':
                    return $this->factory->createTrackDataPoolPushEventHandler($event);
            }
        }
    }
}

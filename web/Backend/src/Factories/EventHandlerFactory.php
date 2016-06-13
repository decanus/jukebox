<?php

namespace Jukebox\Backend\Factories
{

    use Jukebox\Framework\Factories\AbstractFactory;

    class EventHandlerFactory extends AbstractFactory
    {
        public function createInitialVevoArtistsImportEventHandler(): \Jukebox\Backend\EventHandlers\Import\InitialVevoArtistsImportEventHandler
        {
            return new \Jukebox\Backend\EventHandlers\Import\InitialVevoArtistsImportEventHandler(
                $this->getMasterFactory()->createVevoService(),
                $this->getMasterFactory()->createEventQueueWriter()
            );
        }
        
        public function createVevoGenresImportEventHandler(): \Jukebox\Backend\EventHandlers\Import\VevoGenresImportEventHandler
        {
            return new \Jukebox\Backend\EventHandlers\Import\VevoGenresImportEventHandler(
                $this->getMasterFactory()->createVevoService(),
                $this->getMasterFactory()->createInsertGenreCommand()
            );
        }

        public function createVevoArtistImportEventHandler(\Jukebox\Backend\Events\VevoArtistImportEvent $event): \Jukebox\Backend\EventHandlers\Import\VevoArtistImportEventHandler
        {
            return new \Jukebox\Backend\EventHandlers\Import\VevoArtistImportEventHandler(
                $event,
                $this->getMasterFactory()->createVevoService(),
                $this->getMasterFactory()->createInsertArtistCommand(),
                $this->getMasterFactory()->createFetchArtistByVevoIdQuery()
            );
        }

        public function createVevoArtistVideosImportEventHandler(\Jukebox\Backend\Events\VevoArtistVideosImportEvent $event): \Jukebox\Backend\EventHandlers\Import\VevoArtistVideosImportEventHandler
        {
            return new \Jukebox\Backend\EventHandlers\Import\VevoArtistVideosImportEventHandler(
                $event,
                $this->getMasterFactory()->createVevoService(),
                $this->getMasterFactory()->createFetchArtistByVevoIdQuery(),
                $this->getMasterFactory()->createInsertTrackCommand(),
                $this->getMasterFactory()->createInsertTrackArtistCommand(),
                $this->getMasterFactory()->createInsertTrackGenreCommand(),
                $this->getMasterFactory()->createFetchTrackByVevoIdQuery(),
                $this->getMasterFactory()->createInsertTrackSourceCommand()
            );
        }

        public function createInitialVevoArtistsVideosImportEventHandler(): \Jukebox\Backend\EventHandlers\Import\InitialVevoArtistsVideosImportEventHandler
        {
            return new \Jukebox\Backend\EventHandlers\Import\InitialVevoArtistsVideosImportEventHandler(
                $this->getMasterFactory()->createFetchVevoArtistsQuery(),
                $this->getMasterFactory()->createEventQueueWriter()
            );
        }

        public function createElasticsearchIndexPushEventHandler(\Jukebox\Backend\Events\ElasticsearchIndexPushEvent $event): \Jukebox\Backend\EventHandlers\Push\ElasticsearchIndexPushEventHandler
        {
            return new \Jukebox\Backend\EventHandlers\Push\ElasticsearchIndexPushEventHandler(
                $event,
                $this->getMasterFactory()->createElasticsearchClient(),
                $this->getMasterFactory()->createFileBackend(),
                __DIR__ . '/../../data/elasticsearch/mappings/',
                __DIR__ . '/../../data/elasticsearch/settings.json'
            );
        }

        public function createArtistsToElasticsearchPushEventHandler(\Jukebox\Backend\Events\ArtistsToElasticsearchPushEvent $event): \Jukebox\Backend\EventHandlers\Push\ArtistsToElasticsearchPushEventHandler
        {
            return new \Jukebox\Backend\EventHandlers\Push\ArtistsToElasticsearchPushEventHandler(
                $event,
                $this->getMasterFactory()->createElasticsearchClient(),
                $this->getMasterFactory()->createFetchArtistsQuery()
            );
        }

        public function createTracksToElasticsearchPushEventHandler(\Jukebox\Backend\Events\TracksToElasticsearchPushEvent $event): \Jukebox\Backend\EventHandlers\Push\TracksToElasticsearchPushEventHandler
        {
            return new \Jukebox\Backend\EventHandlers\Push\TracksToElasticsearchPushEventHandler(
                $event,
                $this->getMasterFactory()->createElasticsearchClient(),
                $this->getMasterFactory()->createFetchTracksQuery(),
                $this->getMasterFactory()->createFetchTrackArtistsQuery(),
                $this->getMasterFactory()->createFetchTrackGenresQuery(),
                $this->getMasterFactory()->createFetchTrackSourcesQuery()
            );
        }

        public function createInitialEventHandler(): \Jukebox\Backend\EventHandlers\InitialEventHandler
        {
            return new \Jukebox\Backend\EventHandlers\InitialEventHandler(
                $this->getMasterFactory()->createEventQueueWriter(),
                !$this->getMasterFactory()->getConfiguration()->isDevelopmentMode()
            );
        }
        
        public function createTrackPathsPushEventHandler(\Jukebox\Backend\Events\TrackPathsPushEvent $event): \Jukebox\Backend\EventHandlers\Push\TrackPathsPushEventHandler
        {
            return new \Jukebox\Backend\EventHandlers\Push\TrackPathsPushEventHandler(
                $this->getMasterFactory()->createFetchTrackPathsQuery(),
                $this->getMasterFactory()->createDataPoolWriter($event->getDataVersion())
            );
        }
        
        public function createArtistPathsPushEventHandler(\Jukebox\Backend\Events\ArtistPathsPushEvent $event): \Jukebox\Backend\EventHandlers\Push\ArtistPathsPushEventHandler
        {
            return new \Jukebox\Backend\EventHandlers\Push\ArtistPathsPushEventHandler(
                $this->getMasterFactory()->createFetchArtistPathsQuery(),
                $this->getMasterFactory()->createDataPoolWriter($event->getDataVersion())
            );
        }

        public function createDataVersionPushEventHandler(\Jukebox\Backend\Events\DataVersionPushEvent $event): \Jukebox\Backend\EventHandlers\Push\DataVersionPushEventHandler
        {
            return new \Jukebox\Backend\EventHandlers\Push\DataVersionPushEventHandler(
                $event,
                $this->getMasterFactory()->createRedisBackend()
            );
        }

        public function createElasticsearchIndexDeleteEventHandler(\Jukebox\Backend\Events\ElasticsearchIndexDeleteEvent $event): \Jukebox\Backend\EventHandlers\ElasticsearchIndexDeleteEventHandler
        {
            return new \Jukebox\Backend\EventHandlers\ElasticsearchIndexDeleteEventHandler(
                $event,
                $this->getMasterFactory()->createElasticsearchClient()
            );
        }

        public function createOldDataVersionDeleteEventHandler(\Jukebox\Backend\Events\OldDataVersionDeleteEvent $event): \Jukebox\Backend\EventHandlers\OldDataVersionDeleteEventHandler
        {
            return new \Jukebox\Backend\EventHandlers\OldDataVersionDeleteEventHandler(
                $event,
                $this->getMasterFactory()->createRedisBackend()
            );
        }
    }
}

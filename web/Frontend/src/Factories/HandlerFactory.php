<?php

namespace Jukebox\Frontend\Factories
{

    use Jukebox\Framework\Factories\AbstractFactory;
    use Jukebox\Frontend\Session\Session;
    use TheSeer\fDOM\fDOMDocument;

    class HandlerFactory extends AbstractFactory
    {
        /**
         * @var fDomDocument
         */
        private $template;

        /**
         * @var Session
         */
        private $session;

        public function __construct(Session $session)
        {
            $this->session = $session;
        }

        public function createGenericPageTransformationHandler(): \Jukebox\Frontend\Handlers\Get\GenericPageTransformationHandler
        {
            return new \Jukebox\Frontend\Handlers\Get\GenericPageTransformationHandler(
                $this->getTemplate(),
                $this->getMasterFactory()->createAppendTrackingSnippetTransformation(),
                $this->getMasterFactory()->createTwitterCardTagsTransformation(),
                $this->getMasterFactory()->createMetaTagsTransformation()
            );
        }

        public function createCommandHandler(): \Jukebox\Frontend\Handlers\CommandHandler
        {
            return new \Jukebox\Frontend\Handlers\CommandHandler;
        }

        public function createPostHandler(): \Jukebox\Frontend\Handlers\PostHandler
        {
            return new \Jukebox\Frontend\Handlers\PostHandler;
        }

        public function createPreHandler(): \Jukebox\Frontend\Handlers\PreHandler
        {
            return new \Jukebox\Frontend\Handlers\PreHandler;
        }

        public function createQueryHandler(): \Jukebox\Frontend\Handlers\QueryHandler
        {
            return new \Jukebox\Frontend\Handlers\QueryHandler;
        }

        public function createResponseHandler(): \Jukebox\Frontend\Handlers\ResponseHandler
        {
            return new \Jukebox\Frontend\Handlers\ResponseHandler(
                $this->session
            );
        }

        public function createTransformationHandler(): \Jukebox\Frontend\Handlers\TransformationHandler
        {
            return new \Jukebox\Frontend\Handlers\TransformationHandler;
        }
        
        public function createHomepageTransformationHandler(): \Jukebox\Frontend\Handlers\Get\Homepage\TransformationHandler
        {
            return new \Jukebox\Frontend\Handlers\Get\Homepage\TransformationHandler(
                $this->getTemplate(),
                $this->getMasterFactory()->createGenericPageTransformationHandler(),
                $this->getMasterFactory()->createFileBackend()
            );
        }

        public function createTrackPageTransformationHandler(): \Jukebox\Frontend\Handlers\Get\Track\TransformationHandler
        {
            return new \Jukebox\Frontend\Handlers\Get\Track\TransformationHandler(
                $this->getTemplate(),
                $this->getMasterFactory()->createGenericPageTransformationHandler(),
                $this->getMasterFactory()->createFileBackend()
            );
        }
        
        public function createTrackPageQueryHandler(): \Jukebox\Frontend\Handlers\Get\Track\QueryHandler
        {
            return new \Jukebox\Frontend\Handlers\Get\Track\QueryHandler(
                $this->getMasterFactory()->createDataPoolReader(),
                $this->getMasterFactory()->createJukeboxRestManager()
            );
        }

        public function createArtistPageQueryHandler(): \Jukebox\Frontend\Handlers\Get\Artist\QueryHandler
        {
            return new \Jukebox\Frontend\Handlers\Get\Artist\QueryHandler(
                $this->getMasterFactory()->createDataPoolReader(),
                $this->getMasterFactory()->createJukeboxRestManager()
            );
        }

        public function createArtistPageTransformationHandler(): \Jukebox\Frontend\Handlers\Get\Artist\TransformationHandler
        {
            return new \Jukebox\Frontend\Handlers\Get\Artist\TransformationHandler(
                $this->getTemplate(),
                $this->getMasterFactory()->createGenericPageTransformationHandler(),
                $this->getMasterFactory()->createFileBackend()
            );
        }


        public function createNotFoundTransformationHandler(): \Jukebox\Frontend\Handlers\Get\NotFound\TransformationHandler
        {
            return new \Jukebox\Frontend\Handlers\Get\NotFound\TransformationHandler(
                $this->getTemplate(),
                $this->getMasterFactory()->createGenericPageTransformationHandler(),
                $this->getMasterFactory()->createFileBackend()
            );
        }

        public function createAjaxTransformationHandler(): \Jukebox\Frontend\Handlers\Get\Ajax\TransformationHandler
        {
            return new \Jukebox\Frontend\Handlers\Get\Ajax\TransformationHandler;
        }

        public function createAjaxSearchQueryHandler(): \Jukebox\Frontend\Handlers\Get\Ajax\Search\QueryHandler
        {
            return new \Jukebox\Frontend\Handlers\Get\Ajax\Search\QueryHandler(
                $this->getMasterFactory()->createJukeboxRestManager()
            );
        }

        public function createSearchPageQueryHandler(): \Jukebox\Frontend\Handlers\Get\Search\QueryHandler
        {
            return new \Jukebox\Frontend\Handlers\Get\Search\QueryHandler(
                $this->getMasterFactory()->createJukeboxRestManager()
            );
        }

        public function createSearchPageTransformationHandler(): \Jukebox\Frontend\Handlers\Get\Search\TransformationHandler
        {
            return new \Jukebox\Frontend\Handlers\Get\Search\TransformationHandler(
                $this->getTemplate(),
                $this->getMasterFactory()->createGenericPageTransformationHandler(),
                $this->getMasterFactory()->createFileBackend()
            );
        }

        public function createResolveQueryHandler(): \Jukebox\Frontend\Handlers\Get\Ajax\Resolve\QueryHandler
        {
            return new \Jukebox\Frontend\Handlers\Get\Ajax\Resolve\QueryHandler(
                $this->getMasterFactory()->createDataPoolReader(),
                $this->getMasterFactory()->createJukeboxRestManager()
            );
        }

        public function createResolveTransformationHandler(): \Jukebox\Frontend\Handlers\Get\Ajax\Resolve\TransformationHandler
        {
            return new \Jukebox\Frontend\Handlers\Get\Ajax\Resolve\TransformationHandler;
        }

        public function createArtistTracksQueryHandler(): \Jukebox\Frontend\Handlers\Get\Ajax\ArtistTracks\QueryHandler
        {
            return new \Jukebox\Frontend\Handlers\Get\Ajax\ArtistTracks\QueryHandler(
                $this->getMasterFactory()->createJukeboxRestManager()
            );
        }

        public function createArtistWebProfilesQueryHandler(): \Jukebox\Frontend\Handlers\Get\Ajax\ArtistWebProfiles\QueryHandler
        {
            return new \Jukebox\Frontend\Handlers\Get\Ajax\ArtistWebProfiles\QueryHandler(
                $this->getMasterFactory()->createJukeboxRestManager()
            );
        }

        public function createGetArtistQueryHandler(): \Jukebox\Frontend\Handlers\Get\Ajax\Artist\QueryHandler
        {
            return new \Jukebox\Frontend\Handlers\Get\Ajax\Artist\QueryHandler(
                $this->getMasterFactory()->createJukeboxRestManager()
            );
        }

        public function createGetTrackQueryHandler(): \Jukebox\Frontend\Handlers\Get\Ajax\Track\QueryHandler
        {
            return new \Jukebox\Frontend\Handlers\Get\Ajax\Track\QueryHandler(
                $this->getMasterFactory()->createJukeboxRestManager()
            );
        }

        /**
         * @return fDOMDocument
         */
        public function getTemplate(): fDOMDocument
        {
            if ($this->template === null) {
                $this->template = new fDomDocument;
                $this->template->loadXML($this->getMasterFactory()->createFileBackend()->load(__DIR__ . '/../../data/templates/template.xhtml'));
                $this->template->registerNamespace('html', 'http://www.w3.org/1999/xhtml');
            }
            return $this->template;
        }
    }
}

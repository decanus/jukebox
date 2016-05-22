<?php

namespace Jukebox\Frontend\Factories
{

    use Jukebox\Framework\Factories\AbstractFactory;
    use TheSeer\fDOM\fDOMDocument;

    class HandlerFactory extends AbstractFactory
    {
        /**
         * @var fDomDocument
         */
        private $template;

        public function createGenericPageTransformationHandler(): \Jukebox\Frontend\Handlers\Get\GenericPageTransformationHandler
        {
            return new \Jukebox\Frontend\Handlers\Get\GenericPageTransformationHandler(
                $this->getTemplate(),
                $this->getMasterFactory()->createAppendTrackingSnippetTransformation()
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
            return new \Jukebox\Frontend\Handlers\ResponseHandler;
        }

        public function createTransformationHandler(): \Jukebox\Frontend\Handlers\TransformationHandler
        {
            return new \Jukebox\Frontend\Handlers\TransformationHandler;
        }
        
        public function createHomepageTransformationHandler(): \Jukebox\Frontend\Handlers\Get\Homepage\TransformationHandler
        {
            return new \Jukebox\Frontend\Handlers\Get\Homepage\TransformationHandler(
                $this->getTemplate(),
                $this->getMasterFactory()->createGenericPageTransformationHandler()
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

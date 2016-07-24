<?php

namespace Jukebox\Mirror\Factories
{

    use Jukebox\Framework\Factories\AbstractFactory;
    use TheSeer\fDOM\fDOMDocument;

    class HandlerFactory extends AbstractFactory
    {
        /**
         * @var fDOMDocument
         */
        private $template;

        public function createCommandHandler(): \Jukebox\Mirror\Handlers\CommandHandler
        {
            return new \Jukebox\Mirror\Handlers\CommandHandler;
        }

        public function createPostHandler(): \Jukebox\Mirror\Handlers\PostHandler
        {
            return new \Jukebox\Mirror\Handlers\PostHandler;
        }

        public function createPreHandler(): \Jukebox\Mirror\Handlers\PreHandler
        {
            return new \Jukebox\Mirror\Handlers\PreHandler;
        }

        public function createQueryHandler(): \Jukebox\Mirror\Handlers\QueryHandler
        {
            return new \Jukebox\Mirror\Handlers\QueryHandler;
        }

        public function createResponseHandler(): \Jukebox\Mirror\Handlers\ResponseHandler
        {
            return new \Jukebox\Mirror\Handlers\ResponseHandler;
        }

        public function createTransformationHandler(): \Jukebox\Mirror\Handlers\TransformationHandler
        {
            return new \Jukebox\Mirror\Handlers\TransformationHandler(
                $this->getTemplate()
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

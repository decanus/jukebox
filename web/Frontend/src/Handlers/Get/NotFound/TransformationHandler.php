<?php

namespace Jukebox\Frontend\Handlers\Get\NotFound
{

    use Jukebox\Framework\Backends\FileBackend;
    use Jukebox\Frontend\Handlers\Get\AbstractTransformationHandler;
    use Jukebox\Frontend\Handlers\Get\GenericPageTransformationHandler;
    use TheSeer\fDOM\fDOMDocument;

    class TransformationHandler extends AbstractTransformationHandler
    {
        /**
         * @var FileBackend
         */
        private $fileBackend;

        public function __construct(
            fDOMDocument $template,
            GenericPageTransformationHandler $genericPageTransformationHandler,
            FileBackend $fileBackend
        )
        {
            parent::__construct($template, $genericPageTransformationHandler);
            $this->fileBackend = $fileBackend;
        }

        protected function doExecute()
        {
            $template = $this->getTemplate();

            $template->queryOne('/html:html/html:head/html:title')->nodeValue = 'Not Found - Jukebox Ninja';

            $content = new fDOMDocument;
            $content->loadXML($this->fileBackend->load('templates://content/404.xml'));

            $main = $template->queryOne('//html:app-mount');

            $main->appendChild($template->importNode($content->documentElement, true));

        }
    }
}

<?php

namespace Jukebox\Frontend\Transformations
{

    use Jukebox\Framework\Backends\FileBackend;
    use TheSeer\fDOM\fDOMDocument;

    class AppendTrackingSnippetTransformation
    {
        /**
         * @var bool
         */
        private $isDevelopment;

        /**
         * @var FileBackend
         */
        private $fileBackend;

        public function __construct(FileBackend $fileBackend, $isDevelopment = false)
        {
            $this->isDevelopment = $isDevelopment;
            $this->fileBackend = $fileBackend;
        }

        public function transform(fDOMDocument $template)
        {
            if ($this->isDevelopment) {
                return;
            }

            $tracking = new fDOMDocument;
            $tracking->loadXML($this->fileBackend->load('templates://content/tracking/googleAnalytics.xml'));
            $template->queryOne('//html:body')->appendChild($template->importNode($tracking->documentElement, true));
        }
    }
}

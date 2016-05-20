<?php

namespace Jukebox\Frontend\Transformations
{

    use Jukebox\Framework\Backends\FileBackend;
    use TheSeer\fDOM\fDOMDocument;

    class AppendTrackingSnippetTransformation
    {
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
            $tracking->loadXML($this->fileBackend->load(__DIR__ . '/../../data/templates/trackingSnippet.xml'));
            $template->queryOne('//html:body')->appendChild($template->importNode($tracking->documentElement, true));
        }
    }
}

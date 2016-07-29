<?php

namespace Jukebox\Backend\Sitemap
{

    use Jukebox\Backend\ValueObjects\Sitemap\ChangeFrequency\ChangeFrequency;
    use Jukebox\Backend\ValueObjects\Sitemap\Priority;
    use Jukebox\Framework\ValueObjects\Uri;
    use TheSeer\fDOM\fDOMDocument;

    class Sitemap
    {
        /**
         * @var fDOMDocument
         */
        private $document;

        public function __construct(fDOMDocument $document = null)
        {
            if ($document === null) {
                $document = new fDOMDocument;
                $document->registerNamespace('g', 'http://www.sitemaps.org/schemas/sitemap/0.9');
                $urlset = $document->appendElement('urlset');
                $urlset->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
            }

            $this->document = $document;
        }

        public function addUri(Uri $uri, ChangeFrequency $changeFrequency, Priority $priority)
        {
            $url = $this->document->documentElement->appendElement('url');
            $url->appendElement('loc', (string) $uri);
            $url->appendElement('changefreq', (string) $changeFrequency);
            $url->appendElement('priority', (string) $priority);
        }

        public function getDom(): fDOMDocument
        {
            return $this->document;
        }
    }
}

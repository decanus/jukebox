<?php

namespace Jukebox\Backend\Sitemap
{

    use Jukebox\Backend\ValueObjects\ChangeFrequency\ChangeFrequency;
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

        public function addUri(Uri $uri, ChangeFrequency $changeFrequency)
        {
            $url = $this->document->documentElement->appendElement('url');
            $url->appendElement('loc', (string) $uri);
            $url->appendElement('changefreq', (string) $changeFrequency);
        }

        public function getDom(): fDOMDocument
        {
            return $this->document;
        }
    }
}

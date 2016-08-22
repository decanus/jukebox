<?php

namespace Jukebox\Backend\Services
{

    use Jukebox\Framework\Curl\Curl;
    use Jukebox\Framework\Curl\RollingCurl;
    use Jukebox\Framework\ValueObjects\Uri;

    abstract class AbstractService
    {
        /**
         * @var Uri
         */
        private $baseUri;
        
        /**
         * @var Curl
         */
        private $curl;

        /**
         * @var RollingCurl
         */
        private $rollingCurl;

        public function __construct(Uri $baseUri, Curl $curl, RollingCurl $rollingCurl)
        {
            $this->baseUri = $baseUri;
            $this->curl = $curl;
            $this->rollingCurl = $rollingCurl;
        }

        protected function buildUrl(string $path, array $query = []): Uri
        {
            $queryString = '';
            if (!empty($query)) {
                $queryString = '?' . http_build_query($query);
            }

            return new Uri($this->baseUri . $path . $queryString);
        }

        protected function getCurl(): Curl
        {
            return $this->curl;
        }

        protected function getRollingCurl(): RollingCurl
        {
            return $this->rollingCurl;
        }

    }
}

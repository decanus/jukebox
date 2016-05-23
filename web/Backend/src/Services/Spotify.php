<?php

namespace Jukebox\Backend\Services
{

    use Jukebox\Framework\Curl\Curl;
    use Jukebox\Framework\Curl\Response;
    use Jukebox\Framework\ValueObjects\Uri;

    class Spotify
    {
        /**
         * @var Curl
         */
        private $curl;

        /**
         * @var Uri
         */
        private $baseUri;

        public function __construct(Uri $baseUri, Curl $curl)
        {
            $this->curl = $curl;
            $this->baseUri = $baseUri;
        }
        
        public function getArtist(string $artistId): Response
        {
            return $this->curl->get(new Uri($this->baseUri . '/v1/artists/' . $artistId));
        }
    }
}

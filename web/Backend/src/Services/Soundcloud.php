<?php

namespace Jukebox\Backend\Services
{

    use Jukebox\Framework\Curl\Curl;
    use Jukebox\Framework\Curl\Response;
    use Jukebox\Framework\Curl\RollingCurl;
    use Jukebox\Framework\ValueObjects\Uri;

    class Soundcloud extends AbstractService
    {

        /**
         * @var string
         */
        private $clientId;

        public function __construct(Uri $baseUri, Curl $curl, RollingCurl $rollingCurl, string $clientId)
        {
            parent::__construct($baseUri, $curl, $rollingCurl);
            $this->clientId = $clientId;
        }

        public function searchForArtist(string $artist): Response
        {
            return $this->getCurl()->get($this->buildUrl('/users'), ['q' => $artist, 'client_id' => $this->clientId]);
        }

        public function getArtistTracks(string $artist): Response
        {
            return $this->getCurl()->get($this->buildUrl('/users/' . $artist . '/tracks'), ['client_id' => $this->clientId]);
        }
    }
}

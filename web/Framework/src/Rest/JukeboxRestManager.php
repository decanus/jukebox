<?php

namespace Jukebox\Framework\Rest
{

    use Jukebox\Framework\Curl\Curl;
    use Jukebox\Framework\Curl\Response;
    use Jukebox\Framework\ValueObjects\Uri;

    class JukeboxRestManager
    {
        /**
         * @var Curl
         */
        private $curl;

        /**
         * @var Uri
         */
        private $uri;

        /**
         * @var string
         */
        private $key;

        public function __construct(Curl $curl, Uri $uri, string $key)
        {
            $this->curl = $curl;
            $this->uri = $uri;
            $this->key = $key;
        }

        public function getTrackById(string $id): Response
        {
            return $this->curl->get($this->buildUri('/v1/tracks/' . $id), ['key' => $this->key]);
        }

        private function buildUri(string $path): Uri
        {
            return new Uri($this->uri . $path);
        }
    }
}

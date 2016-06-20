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

        public function getArtistById(string $id): Response
        {
            return $this->curl->get($this->buildUri('/v1/artists/' . $id), ['key' => $this->key]);
        }

        public function getTracksByArtistId(string $id, int $size = 20, int $page = 1): Response
        {
            return $this->curl->get($this->buildUri('/v1/artists/' . $id . '/tracks'), ['key' => $this->key, 'size' => $size, 'page' => $page]);
        }

        public function getWebProfilesByArtistId(string $id): Response
        {
            return $this->curl->get($this->buildUri('/v1/artists/' . $id . '/web-profiles'), ['key' => $this->key]);
        }

        public function search(string $searchTerm, int $size, int $page): Response
        {
            return $this->curl->get($this->buildUri('/v1/search'), ['key' => $this->key, 'query' => $searchTerm, 'size' => $size, 'page' => $page]);
        }

        private function buildUri(string $path): Uri
        {
            return new Uri($this->uri . $path);
        }
    }
}

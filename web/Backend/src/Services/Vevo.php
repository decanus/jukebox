<?php

namespace Jukebox\Backend\Services
{

    use Jukebox\Framework\Curl\Curl;
    use Jukebox\Framework\Curl\Response;
    use Jukebox\Framework\DataPool\RedisBackend;
    use Jukebox\Framework\ValueObjects\Uri;

    class Vevo
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
         * @var RedisBackend
         */
        private $redisBackend;

        public function __construct(Uri $baseUri, Curl $curl, RedisBackend $redisBackend)
        {
            $this->baseUri = $baseUri;
            $this->curl = $curl;
            $this->redisBackend = $redisBackend;
        }

        public function getVideoForId(string $videoId): Response
        {
            return $this->curl->get(
                $this->buildUrl('/video/' . $videoId),
                ['token' => $this->getAuthorizationToken()]
            );
        }

        public function getVideosForIds(array $videoIds): array
        {
            foreach ($videoIds as $videoId) {
                $this->curl->getMulti($this->buildUrl('/video/' . $videoId), ['token' => $this->getAuthorizationToken()]);
            }

            return $this->curl->sendMultiRequest();
        }

        public function getArtist(string $artistId): Response
        {
            return $this->curl->get($this->buildUrl('/artist/' . $artistId), ['token' => $this->getAuthorizationToken()]);
        }

        public function getArtists($page = 1): Response
        {
            return $this->curl->get(
                $this->buildUrl('/artists'),
                ['token' => $this->getAuthorizationToken(), 'page' => $page, 'size' => 200]
            );
        }
        
        public function getGenres(): Response
        {
            return $this->curl->get(
                $this->buildUrl('/genres'),
                ['token' => $this->getAuthorizationToken() ]
            );
        }

        private function buildUrl(string $path): Uri
        {
            return new Uri($this->baseUri . $path);
        }

        private function getAuthorizationToken(): string
        {
            if (!$this->redisBackend->has('vevo_accesstoken')) {
                $response = $this->curl->post(new Uri('http://www.vevo.com/auth'));

                if ($response->getResponseCode() !== 200) {
                    throw new \Exception('Authorization Failed');
                }

                $data = $response->getDecodedJsonResponse();

                if (!isset($data['access_token'])) {
                    throw new \Exception('Access Token was not recieved');
                }
                
                $this->redisBackend->set('vevo_accesstoken', $data['access_token']);
                $this->redisBackend->expireAt('vevo_accesstoken', $data['expires']);
            }

            return $this->redisBackend->get('vevo_accesstoken');
        }
    }
}

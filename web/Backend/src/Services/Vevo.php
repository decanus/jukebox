<?php

namespace Jukebox\Backend\Services
{

    use Jukebox\Framework\Curl\Curl;
    use Jukebox\Framework\Curl\Response;
    use Jukebox\Framework\Curl\RollingCurl;
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

        /**
         * @var RollingCurl
         */
        private $rollingCurl;

        public function __construct(
            Uri $baseUri,
            Curl $curl,
            RollingCurl $rollingCurl,
            RedisBackend $redisBackend
        )
        {
            $this->baseUri = $baseUri;
            $this->curl = $curl;
            $this->redisBackend = $redisBackend;
            $this->rollingCurl = $rollingCurl;
        }

        public function getVideoForId(string $videoId): Response
        {
            return $this->curl->get(
                $this->buildUrl('/video/' . $videoId),
                ['token' => $this->getAuthorizationToken()]
            );
        }

        public function getVideosForIds(array $videoIds, array $callback, $processingLimit = 10)
        {
            $this->rollingCurl->setCallback($callback[0], $callback[1]);
            $this->rollingCurl->setProcessingLimit($processingLimit);

            foreach ($videoIds as $videoId) {
                $this->rollingCurl->addRequest(
                    $this->buildUrl('/video/' . $videoId, ['token' => $this->getAuthorizationToken()]), $videoId
                );
            }

            $this->rollingCurl->execute();
        }

        public function getArtist(string $artistId): Response
        {
            return $this->curl->get($this->buildUrl('/artist/' . urlencode($artistId)), ['token' => $this->getAuthorizationToken()]);
        }

        public function getVideosForArtist(string $artistId, $page = 1): Response
        {
            return $this->curl->get(
                $this->buildUrl('/artist/' . $artistId . '/videos'),
                ['token' => $this->getAuthorizationToken(), 'page' => $page, 'size' => 200]
            );
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

        private function buildUrl(string $path, array $query = []): Uri
        {
            $queryString = '';
            if (!empty($query)) {
                $queryString = '?' . http_build_query($query);
            }

            return new Uri($this->baseUri . $path . $queryString);
        }

        private function getAuthorizationToken(): string
        {
            if (!$this->redisBackend->has('vevo_accesstoken')) {
                $response = $this->curl->post(new Uri('http://www.vevo.com/auth'), [], ['Accept: */*', 'Expect:', 'Content-type:', 'Content-length:']);

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

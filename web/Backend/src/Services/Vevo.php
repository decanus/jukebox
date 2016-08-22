<?php

namespace Jukebox\Backend\Services
{

    use Jukebox\Framework\Curl\Curl;
    use Jukebox\Framework\Curl\Response;
    use Jukebox\Framework\Curl\RollingCurl;
    use Jukebox\Framework\DataPool\RedisBackend;
    use Jukebox\Framework\ValueObjects\Uri;

    class Vevo extends AbstractService
    {
        /**
         * @var RedisBackend
         */
        private $redisBackend;

        public function __construct(
            Uri $baseUri,
            Curl $curl,
            RollingCurl $rollingCurl,
            RedisBackend $redisBackend
        )
        {
            parent::__construct($baseUri, $curl, $rollingCurl);
            $this->redisBackend = $redisBackend;
        }

        public function getVideoForId(string $videoId): Response
        {
            return $this->getCurl()->get(
                $this->buildUrl('/video/' . $videoId),
                ['token' => $this->getAccessToken()]
            );
        }

        public function getVideosForIds(array $videoIds, array $callback, $processingLimit = 10)
        {
            $this->getRollingCurl()->setCallback($callback[0], $callback[1]);
            $this->getRollingCurl()->setProcessingLimit($processingLimit);

            foreach ($videoIds as $videoId) {
                $this->getRollingCurl()->addRequest(
                    $this->buildUrl('/video/' . $videoId, ['token' => $this->getAccessToken()]), $videoId
                );
            }

            $this->getRollingCurl()->execute();
        }

        public function getArtist(string $artistId): Response
        {
            return $this->getCurl()->get($this->buildUrl('/artist/' . urlencode($artistId)), ['token' => $this->getAccessToken()]);
        }

        public function getVideosForArtist(string $artistId, $page = 1): Response
        {
            return $this->getCurl()->get(
                $this->buildUrl('/artist/' . urlencode($artistId) . '/videos'),
                ['token' => $this->getAuthorizationToken(), 'page' => $page, 'size' => 200]
            );
        }

        public function getArtists($page = 1): Response
        {
            return $this->getCurl()->get(
                $this->buildUrl('/artists'),
                ['token' => $this->getAccessToken(), 'page' => $page, 'size' => 200]
            );
        }
        
        public function getGenres(): Response
        {
            return $this->getCurl()->get(
                $this->buildUrl('/genres'),
                ['token' => $this->getAccessToken()]
            );
        }

        private function getAccessToken(): string
        {
            if (!$this->redisBackend->has('vevo_accesstoken')) {
                $response = $this->getCurl()->post(new Uri('http://www.vevo.com/auth'), [], ['Accept: */*', 'Expect:', 'Content-type:', 'Content-length:']);

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

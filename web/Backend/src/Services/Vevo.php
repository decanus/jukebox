<?php

namespace Jukebox\Backend\Services
{

    use Jukebox\Framework\Curl\Curl;
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

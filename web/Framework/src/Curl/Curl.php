<?php

namespace Jukebox\Framework\Curl
{

    use Jukebox\Framework\ValueObjects\Uri;

    class Curl
    {
        /**
         * @var CurlHandler
         */
        private $curlHandler;

        /**
         * @var CurlMultiHandler
         */
        private $curlMultiHandler;

        /**
         * @param CurlHandler      $curlHandler
         * @param CurlMultiHandler $curlMultiHandler
         */
        public function __construct(CurlHandler $curlHandler, CurlMultiHandler $curlMultiHandler)
        {
            $this->curlHandler = $curlHandler;
            $this->curlMultiHandler = $curlMultiHandler;
        }

        public function get(Uri $uri, array $params = []): Response
        {
            return $this->sendRequest('GET', $uri, $params);
        }

        public function post(Uri $uri, array $params = [], array $headers = []): Response
        {
            return $this->sendRequest('POST', $uri, $params, $headers);
        }

        public function patch(Uri $uri, array $params = []): Response
        {
            return $this->sendRequest('PATCH', $uri, $params);
        }

        public function delete(Uri $uri, array $params = []): Response
        {
            return $this->sendRequest('DELETE', $uri, $params);
        }
        
        public function put(Uri $uri, array $params = []): Response
        {
            return $this->sendRequest('PUT', $uri, $params);
        }
        
        public function getMulti(Uri $uri, array $params = [], string $id = '')
        {
            $this->curlMultiHandler->addRequest($uri, $params, $id, 'GET');
        }

        public function putMulti(Uri $uri, array $params = [], string $id = ''): Response
        {
            $this->curlMultiHandler->addRequest($uri, $params, $id, 'PUT');
        }

        /**
         * @return Response[]
         */
        public function sendMultiRequest()
        {
            return $this->curlMultiHandler->sendRequest();
        }

        private function sendRequest(string $method, Uri $uri, array $params = [], array $headers = []): Response
        {
            return $this->curlHandler->sendRequest($method, $uri, $params, $headers);
        }
    }
}

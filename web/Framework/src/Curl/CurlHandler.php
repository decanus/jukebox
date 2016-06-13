<?php

namespace Jukebox\Framework\Curl
{

    use Jukebox\Framework\ValueObjects\Uri;

    /**
     * @codeCoverageIgnore
     */
    class CurlHandler
    {

        public function sendRequest(string $method, Uri $uri, array $params = [], array $headers = []): Response
        {
            $handle = $this->prepareRequest($method, $uri, $params, $headers);
            $result = curl_exec($handle);

            if (curl_errno($handle)) {
                $error = curl_error($handle);
                $errorNumber = curl_errno($handle);
                curl_close($handle);
                throw new \RuntimeException($error, $errorNumber);
            }

            return $this->buildResponse($result, $handle);
        }

        /**
         * @param string $method
         * @param Uri $uri
         * @param array $params
         * @param array $headers
         *
         * @return resource
         */
        private function prepareRequest(string $method, Uri $uri, array $params = [], array $headers = [])
        {
            $handle = curl_init();

            if ($method === 'DELETE' || $method === 'PUT') {
                curl_setopt($handle, CURLOPT_CUSTOMREQUEST, $method);
            }

            if ($method !== 'POST' && $method !== 'PATCH' && !empty($params)) {
                $uri = (string) $uri . '?' . http_build_query($params);
            }

            if ($method === 'POST' || $method === 'PATCH') {
                curl_setopt($handle, CURLOPT_POST, 1);
                curl_setopt($handle, CURLOPT_POSTFIELDS, $params);
            }

            curl_setopt($handle, CURLOPT_URL, (string) $uri);
            curl_setopt($handle, CURLOPT_HEADER, false);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 150);
            curl_setopt($handle, CURLOPT_USERAGENT, 'Jukebox');
            
            if (!empty($headers)) {
                curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
            }

            return $handle;
        }

        private function buildResponse(string $result, $handle): Response
        {
            $response = new Response;

            $response->setResponseCode(curl_getinfo($handle, CURLINFO_HTTP_CODE));
            $response->setUri(new Uri(curl_getinfo($handle, CURLINFO_EFFECTIVE_URL)));

            curl_close($handle);
            $response->setResponseBody($result);
            return $response;
        }
    }
}

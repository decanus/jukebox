<?php

namespace Jukebox\Framework\Curl
{

    use Jukebox\Framework\ValueObjects\Uri;

    /**
     * @codeCoverageIgnore
     */
    class CurlMultiHandler
    {
        /**
         * @var array
         */
        private $handles = [];

        /**
         * @var array
         */
        private $map = [];

        public function addRequest(Uri $uri, array $params = [], string $id = '', string $method)
        {
            if (!empty($params)) {
                $uri = (string) $uri . '?' . http_build_query($params);
            }

            $handle = curl_init();
            curl_setopt($handle, CURLOPT_URL, (string) $uri);
            curl_setopt($handle, CURLOPT_HEADER, 0);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);

            if ($method === 'PUT') {
                curl_setopt($handle, CURLOPT_CUSTOMREQUEST, "PUT");
            }

            $this->handles[] = $handle;

            if ($id !== '') {
                $this->map[(string) $handle] = $id;
            }

        }

        /**
         * @return Response[]
         */
        public function sendRequest(): array
        {
            $multiHandle = curl_multi_init();

            foreach ($this->handles as $handle) {
                curl_multi_add_handle($multiHandle, $handle);
            }

            $results = [];

            do {
                while (($runningHandle = curl_multi_exec($multiHandle, $running)) == CURLM_CALL_MULTI_PERFORM) ;
                if ($runningHandle != CURLM_OK) {
                    break;
                }
                while ($done = curl_multi_info_read($multiHandle)) {

                    $result = $this->buildResponse(curl_multi_getcontent($done['handle']), $done['handle']);
                    if (isset($this->map[(string) $done['handle']])) {
                        $results[$this->map[(string) $done['handle']]] = $result;
                    } else {
                        $results[] = $result;
                    }

                    curl_multi_remove_handle($multiHandle, $done['handle']);
                    curl_close($done['handle']);
                }

                if ($running) {
                    curl_multi_select($multiHandle);
                }

            } while ($running);

            curl_multi_close($multiHandle);

            $this->handles = [];

            return $results;
        }

        private function buildResponse(string $result, $handle): Response
        {
            $response = new Response;

            $response->setResponseCode(curl_getinfo($handle, CURLINFO_HTTP_CODE));
            $response->setUri(new Uri(curl_getinfo($handle, CURLINFO_EFFECTIVE_URL)));
            $response->setResponseBody($result);

            return $response;
        }
    }
}

<?php

namespace Jukebox\Framework\Curl
{

    use Jukebox\Framework\ValueObjects\Uri;

    class RollingCurl
    {
        /**
         * @var int
         */
        private $limit = 0;

        /**
         * @var array
         */
        private $requests = [];

        /**
         * @var array
         */
        private $map = [];

        /**
         * @var array
         */
        private $options = [
            CURLOPT_CONNECTTIMEOUT_MS => 60000,
            CURLOPT_TIMEOUT_MS => 90000,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_FRESH_CONNECT => 1,
            CURLOPT_FORBID_REUSE => 1,
        ];
        /**
         * @var callback
         */
        private $callback;

        public function execute()
        {
            $master = curl_multi_init();
            if ($this->limit > count($this->requests)) {
                $this->limit = count($this->requests);
            }

            for ($i = 0; $i < $this->limit; $i++) {
                curl_multi_add_handle($master, $this->createCurlHandle($this->requests[$i]));
            }

            do {
                while (($runningHandle = curl_multi_exec($master, $running)) == CURLM_CALL_MULTI_PERFORM);

                if ($runningHandle !== CURLM_OK) {
                    break;
                }

                while ($done = curl_multi_info_read($master)) {

                    if (is_callable($this->callback)) {
                        $output = curl_multi_getcontent($done['handle']);
                        call_user_func(
                            $this->callback,
                            $this->map[(string) $done['handle']],
                            $this->buildResponse($output, $done['handle'])
                        );
                    }

                    if (isset($this->requests[$i]) && $i < count($this->requests)) {
                        curl_multi_add_handle($master, $this->createCurlHandle($this->requests[$i]));
                        $i++;
                    }

                    curl_multi_remove_handle($master, $done['handle']);
                    curl_close($done['handle']);
                }

                if ($running) {
                    curl_multi_select($master);
                }

                gc_collect_cycles();

            } while ($running);
            curl_multi_close($master);
        }

        public function setCallback(object $object, string $method)
        {
            if (!is_callable([$object, $method])) {
                throw new \InvalidArgumentException('Invalid callback');
            }

            $this->callback = [$object, $method];
        }

        public function setProcessingLimit(int $limit = 0)
        {
            $this->limit = $limit;
        }

        public function addRequest(Uri $uri, string $id)
        {
            $this->requests[] = ['uri' => $uri, 'id' => $id];
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

        private function createCurlHandle(array $request): resource
        {
            $ch = curl_init();
            $options = $this->options;
            $options[CURLOPT_URL] = (string) $request['uri'];
            curl_setopt_array($ch, $options);
            $this->map[(string) $ch] = $request['id'];
            return $ch;
        }
    }
}

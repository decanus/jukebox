<?php

namespace Jukebox\Search
{

    use Jukebox\Framework\Curl\Curl;
    use Jukebox\Framework\ValueObjects\Uri;

    class YoutubeSearch implements SearchInterface
    {

        /**
         * @var Curl
         */
        private $curl;

        /**
         * @var string
         */
        private $apiKey;

        /**
         * @var Uri
         */
        private $searchEndpoint;

        public function __construct(Curl $curl, string $apiKey, Uri $searchEndpoint)
        {
            $this->curl = $curl;
            $this->apiKey = $apiKey;
            $this->searchEndpoint = $searchEndpoint;
        }


        public function search(string $query): array
        {
            return $this->curl->get(
                $this->searchEndpoint,
                ['part' => 'snippet', 'query' => $query, 'type' => 'video', 'key' => $this->apiKey]
            )->getDecodedJsonResponse();
        }
    }
}

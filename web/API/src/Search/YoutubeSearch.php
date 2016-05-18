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
            $response = $this->curl->get(
                $this->searchEndpoint,
                ['part' => 'snippet', 'q' => urlencode($query), 'type' => 'video', 'key' => $this->apiKey, 'maxResults' => '20']
            );

            if ($response->getResponseCode() !== 200) {
                throw new \RuntimeException('Something went wrong');
            }

            $data = $response->getDecodedJsonResponse();

            if (!isset($data['items'])) {
                throw new \RuntimeException('Something went wrong');
            }

            $return = [];

            foreach ($data['items'] as $item) {

                $snippet = [
                    'platform' => 'youtube',
                    'title' => $item['snippet']['title'],
                    'artistName' => $item['snippet']['channelTitle'],
                    'id' => $item['id']['videoId']
                ];

                $return[] = $snippet;
            }

            return $return;
        }
    }
}

<?php

namespace Jukebox\Framework\Curl
{

    use Jukebox\Framework\ValueObjects\Uri;
    use TheSeer\fDOM\fDOMDocument;

    class Response
    {
        /**
         * @var int
         */
        private $responseCode;

        /**
         * @var string
         */
        private $body;

        /**
         * @var Uri
         */
        private $uri;

        public function setResponseCode(int $code)
        {
            $this->responseCode = $code;
        }

        public function getResponseCode(): int
        {
            return $this->responseCode;
        }

        public function setResponseBody(string $body)
        {
            $this->body = $body;
        }

        public function getRawResponseBody(): string 
        {
            return $this->body;
        }

        public function getDecodedJsonResponse(): array
        {
            return json_decode($this->getRawResponseBody(), true);
        }

        public function getResponseAsDom(): fDOMDocument
        {
            $dom = new fDOMDocument;
            $dom->loadXML($this->getRawResponseBody());
            return $dom;
        }

        /**
         * @param Uri $uri
         */
        public function setUri(Uri $uri)
        {
            $this->uri = $uri;
        }

        /**
         * @return Uri
         */
        public function getUri()
        {
            return $this->uri;
        }
   
    }
}

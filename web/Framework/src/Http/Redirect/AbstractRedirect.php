<?php

namespace Jukebox\Framework\Http\Redirect
{

    use Jukebox\Framework\Http\StatusCodes\StatusCodeInterface;
    use Jukebox\Framework\ValueObjects\Uri;

    abstract class AbstractRedirect implements RedirectInterface
    {
        /**
         * @var Uri
         */
        private $uri;

        /**
         * @var StatusCodeInterface
         */
        private $statusCode;

        /**
         * @param Uri                 $uri
         * @param StatusCodeInterface $statusCode
         */
        public function __construct(Uri $uri, StatusCodeInterface $statusCode)
        {
            $this->uri = $uri;
            $this->statusCode = $statusCode;
        }

        /**
         * @return Uri
         */
        public function getUri(): Uri
        {
            return $this->uri;
        }

        /**
         * @return StatusCodeInterface
         */
        public function getStatusCode(): StatusCodeInterface
        {
            return $this->statusCode;
        }
    }
}

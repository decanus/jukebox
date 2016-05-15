<?php

namespace Jukebox\Framework\Http\Redirect
{

    use Jukebox\Framework\Http\StatusCodes\StatusCodeInterface;
    use Jukebox\Framework\ValueObjects\Uri;

    class RedirectToPath extends AbstractRedirect
    {
        /**
         * @var string
         */
        private $path;

        /**
         * @param Uri                 $uri
         * @param StatusCodeInterface $statusCode
         * @param string              $path
         */
        public function __construct(Uri $uri, StatusCodeInterface $statusCode, $path)
        {
            parent::__construct($uri, $statusCode);
            $this->path = $path;
        }

        /**
         * @return Uri
         */
        public function getUri(): Uri
        {
            return new Uri('http://' . parent::getUri()->getHost() . $this->path);
        }
    }
}

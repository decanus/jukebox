<?php

namespace Jukebox\Framework\Http\Redirect
{

    use Jukebox\Framework\Http\StatusCodes\StatusCodeInterface;
    use Jukebox\Framework\ValueObjects\Uri;

    interface RedirectInterface
    {
        /**
         * @return Uri
         */
        public function getUri(): Uri;

        /**
         * @return StatusCodeInterface
         */
        public function getStatusCode(): StatusCodeInterface;
    }
}

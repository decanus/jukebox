<?php

namespace Jukebox\Framework\Http\StatusCodes
{

    class NotFound implements StatusCodeInterface
    {
        /**
         * @return string
         */
        public function __toString(): string
        {
            return '404';
        }

        /**
         * @return string
         */
        public function getHeaderString(): string
        {
            return 'Status: 404 Not Found';
        }
    }
}

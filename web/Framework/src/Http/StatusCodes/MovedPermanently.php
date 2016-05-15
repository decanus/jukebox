<?php

namespace Jukebox\Framework\Http\StatusCodes
{

    class MovedPermanently implements StatusCodeInterface
    {
        /**
         * @return string
         */
        public function __toString(): string
        {
            return '301';
        }

        /**
         * @return string
         */
        public function getHeaderString(): string
        {
            return 'Status: 301 Moved Permanently';
        }
    }
}

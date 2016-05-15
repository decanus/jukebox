<?php

namespace Jukebox\Framework\Http\StatusCodes
{

    class MovedTemporarily implements StatusCodeInterface
    {
        /**
         * @return string
         */
        public function __toString(): string
        {
            return '302';
        }

        /**
         * @return string
         */
        public function getHeaderString(): string
        {
            return 'Status: 302 Moved Temporarily';
        }
    }
}

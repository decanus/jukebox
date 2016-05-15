<?php

namespace Jukebox\Framework\Http\StatusCodes
{

    class InternalServerError implements StatusCodeInterface
    {
        /**
         * @return string
         */
        public function __toString(): string
        {
            return '500';
        }

        /**
         * @return string
         */
        public function getHeaderString(): string
        {
            return 'Status: 500 Internal server error';
        }
    }
}

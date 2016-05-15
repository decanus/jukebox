<?php

namespace Jukebox\Framework\Http\StatusCodes
{

    class Unauthorized implements StatusCodeInterface
    {
        /**
         * @return string
         */
        public function __toString(): string
        {
            return '401';
        }

        /**
         * @return string
         */
        public function getHeaderString(): string
        {
            return 'Status: 401 Unauthorized';
        }
    }
}

<?php

namespace Jukebox\Framework\Http\StatusCodes
{

    class BadRequest implements StatusCodeInterface
    {
        /**
         * @return string
         */
        public function __toString(): string
        {
            return '400';
        }

        /**
         * @return string
         */
        public function getHeaderString(): string
        {
            return 'Status: 400 Bad Request';
        }
    }
}

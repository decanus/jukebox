<?php

namespace Jukebox\Framework\Http\StatusCodes
{

    class Conflict implements StatusCodeInterface
    {
        /**
         * @return string
         */
        public function __toString(): string
        {
            return '409';
        }

        /**
         * @return string
         */
        public function getHeaderString(): string
        {
            return 'Status: 409 Conflict';
        }
    }
}

<?php

namespace Jukebox\Framework\Http\StatusCodes
{
    class Forbidden implements StatusCodeInterface
    {

        /**
         * @return string
         */
        public function __toString(): string
        {
            return '403';
        }

        /**
         * @return string
         */
        public function getHeaderString(): string
        {
            return 'Status: 403 Forbidden';
        }
    }
}

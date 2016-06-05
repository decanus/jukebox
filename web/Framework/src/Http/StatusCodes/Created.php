<?php

namespace Jukebox\Framework\Http\StatusCodes
{
    class Created implements StatusCodeInterface
    {

        /**
         * @return string
         */
        public function __toString(): string
        {
            return '201';
        }

        /**
         * @return string
         */
        public function getHeaderString(): string
        {
            return 'Status: 201 Created';
        }
    }
}

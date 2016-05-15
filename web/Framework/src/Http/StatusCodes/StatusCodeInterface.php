<?php

namespace Jukebox\Framework\Http\StatusCodes
{
    interface StatusCodeInterface
    {
        /**
         * @return string
         */
        public function __toString(): string;

        /**
         * @return string
         */
        public function getHeaderString(): string;
    }
}

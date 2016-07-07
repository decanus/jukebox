<?php


namespace Jukebox\Framework\Logging\Logs
{
    interface LogInterface
    {
        public function getMessage(): string;

        public function __toString(): string;
    }
}

<?php


namespace Jukebox\Framework\Logging\Logs
{
    interface LogInterface
    {
        public function getLog(): array;

        public function getMessage(): string;
    }
}

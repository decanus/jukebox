<?php

namespace Jukebox\Framework\Backends\Streams
{

    class TemplatesStreamWrapper extends FileSystemStreamWrapper
    {

        protected function getProtocol(): string
        {
            return 'templates';
        }
    }
}

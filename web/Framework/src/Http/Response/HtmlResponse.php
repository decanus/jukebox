<?php

namespace Jukebox\Framework\Http\Response
{
    class HtmlResponse extends AbstractResponse
    {
        /**
         * @codeCoverageIgnore
         */
        protected function setMimeType()
        {
            $this->setHeader('Content-Type', 'text/html');
        }
    }
}

<?php

namespace Jukebox\Framework\Http\Response
{
    class JsonResponse extends AbstractResponse
    {
        /**
         * @codeCoverageIgnore
         */
        protected function setMimeType()
        {
            $this->setHeader('Content-Type', 'application/json');
        }
    }
}

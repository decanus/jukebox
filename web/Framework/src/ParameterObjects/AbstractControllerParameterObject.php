<?php

namespace Jukebox\Framework\ParamterObjects
{

    use Jukebox\Framework\ValueObjects\Uri;

    abstract class AbstractControllerParameterObject
    {
        /**
         * @var Uri
         */
        private $uri;
        
        public function __construct(Uri $uri)
        {
            $this->uri = $uri;
        }
        
        public function getUri(): Uri
        {
            return $this->uri;
        }
    }
}

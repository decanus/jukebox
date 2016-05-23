<?php

namespace Jukebox\Frontend\Resolvers
{

    use Jukebox\Framework\ValueObjects\Uri;

    interface ResolverInterface
    {
        /**
         * @param Uri $uri
         *
         * @return array
         */
        public function resolve(Uri $uri);
    }
}

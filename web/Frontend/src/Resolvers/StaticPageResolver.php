<?php

namespace Jukebox\Frontend\Resolvers
{

    use Jukebox\Framework\ValueObjects\Uri;

    class StaticPageResolver implements ResolverInterface
    {

        /**
         * @param Uri $uri
         *
         * @return array
         */
        public function resolve(Uri $uri)
        {
            switch ($uri->getPath()) {
                case '/':
                    return ['page' => 'home'];
            }
        }
    }
}

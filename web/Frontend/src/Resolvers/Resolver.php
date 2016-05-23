<?php

namespace Jukebox\Frontend\Resolvers
{

    use Jukebox\Framework\ValueObjects\Uri;

    class Resolver implements ResolverInterface
    {
        /**
         * @var ResolverInterface[]
         */
        private $resolvers = [];

        public function addResolver(ResolverInterface $resolver)
        {
            $this->resolvers[] = $resolver;
        }

        /**
         * @param Uri $uri
         *
         * @return array
         */
        public function resolve(Uri $uri)
        {
            foreach ($this->resolvers as $resolver) {
                $data = $resolver->resolve($uri);
                if ($data !== null) {
                    return $data;
                }
            }

            throw new \InvalidArgumentException('Path "' . $uri->getPath() . '" could not be resolved');
        }
    }
}

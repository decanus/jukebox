<?php

namespace Jukebox\Frontend\Factories
{

    use Jukebox\Framework\Factories\AbstractFactory;

    class TransformationFactory extends AbstractFactory
    {
        public function createAppendTrackingSnippetTransformation(): \Jukebox\Frontend\Transformations\AppendTrackingSnippetTransformation
        {
            return new \Jukebox\Frontend\Transformations\AppendTrackingSnippetTransformation(
                $this->getMasterFactory()->createFileBackend(),
                $this->getMasterFactory()->getConfiguration()->isDevelopmentMode()
            );
        }

        public function createTwitterCardTagsTransformation(): \Jukebox\Frontend\Transformations\TwitterCardTagsTransformation
        {
            return new \Jukebox\Frontend\Transformations\TwitterCardTagsTransformation;
        }

        public function createMetaTagsTransformation(): \Jukebox\Frontend\Transformations\MetaTagsTransformation
        {
            return new \Jukebox\Frontend\Transformations\MetaTagsTransformation;
        }
    }
}

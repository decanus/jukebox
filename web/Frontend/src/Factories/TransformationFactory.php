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
    }
}

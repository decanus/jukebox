<?php

namespace Jukebox\Frontend\Handlers\Get
{

    use Jukebox\Framework\Models\AbstractModel;
    use Jukebox\Frontend\Transformations\AppendTrackingSnippetTransformation;
    use TheSeer\fDOM\fDOMDocument;

    class GenericPageTransformationHandler
    {
        /**
         * @var fDOMDocument
         */
        private $template;

        /**
         * @var AppendTrackingSnippetTransformation
         */
        private $appendTrackingSnippetTransformation;

        public function __construct(
            fDOMDocument $template,
            AppendTrackingSnippetTransformation $appendTrackingSnippetTransformation
        )
        {
            $this->template = $template;
            $this->appendTrackingSnippetTransformation = $appendTrackingSnippetTransformation;
        }

        public function execute(AbstractModel $model)
        {
            $this->appendTrackingSnippetTransformation->transform($this->template);
        }
    }
}

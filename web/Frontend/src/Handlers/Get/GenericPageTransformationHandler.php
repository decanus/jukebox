<?php

namespace Jukebox\Frontend\Handlers\Get
{

    use Jukebox\Framework\Models\AbstractModel;
    use Jukebox\Frontend\Transformations\AppendTrackingSnippetTransformation;
    use Jukebox\Frontend\Transformations\TwitterCardTagsTransformation;
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

        /**
         * @var TwitterCardTagsTransformation
         */
        private $twitterCardTagsTransformation;

        public function __construct(
            fDOMDocument $template,
            AppendTrackingSnippetTransformation $appendTrackingSnippetTransformation,
            TwitterCardTagsTransformation $twitterCardTagsTransformation
        )
        {
            $this->template = $template;
            $this->appendTrackingSnippetTransformation = $appendTrackingSnippetTransformation;
            $this->twitterCardTagsTransformation = $twitterCardTagsTransformation;
        }

        public function execute(AbstractModel $model)
        {
            $this->appendTrackingSnippetTransformation->transform($this->template);
            $this->twitterCardTagsTransformation->transform($this->template, $model);
        }
    }
}

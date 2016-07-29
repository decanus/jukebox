<?php

namespace Jukebox\Mirror\Handlers
{

    use Jukebox\Framework\Handlers\TransformationHandlerInterface;
    use Jukebox\Framework\Models\AbstractModel;
    use TheSeer\fDOM\fDOMDocument;

    class TransformationHandler implements TransformationHandlerInterface
    {
        /**
         * @var fDOMDocument
         */
        private $template;

        public function __construct(fDOMDocument $template)
        {
            $this->template = $template;
        }

        public function execute(AbstractModel $model): string
        {
            return $this->template->saveXML();
        }
    }
}

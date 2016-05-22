<?php

namespace Jukebox\Frontend\Handlers\Get
{

    use Jukebox\Framework\Handlers\TransformationHandlerInterface;
    use Jukebox\Framework\Models\AbstractModel;
    use TheSeer\fDOM\fDOMDocument;

    abstract class AbstractTransformationHandler implements TransformationHandlerInterface
    {
        /**
         * @var AbstractModel
         */
        private $model;

        /**
         * @var fDOMDocument
         */
        private $template;

        /**
         * @var GenericPageTransformationHandler
         */
        private $genericPageTransformationHandler;

        public function __construct(
            fDOMDocument $template,
            GenericPageTransformationHandler $genericPageTransformationHandler
        )
        {
            $this->template = $template;
            $this->genericPageTransformationHandler = $genericPageTransformationHandler;
        }

        public function execute(AbstractModel $model): string
        {
            $this->model = $model;
            $this->doExecute();
            $this->genericPageTransformationHandler->execute($model);

            return $this->template->saveXML();
        }

        protected function getModel(): AbstractModel
        {
            return $this->model;
        }

        protected function getTemplate(): fDOMDocument
        {
            return $this->template;
        }

        abstract protected function doExecute();
    }
}

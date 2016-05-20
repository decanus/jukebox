<?php

namespace Jukebox\Frontend\Handlers\Get
{

    use Jukebox\Framework\Handlers\TransformationHandlerInterface;
    use Jukebox\Framework\Models\AbstractModel;

    abstract class AbstractTransformationHandler implements TransformationHandlerInterface
    {
        private $model;

        public function execute(AbstractModel $model): string
        {
            $this->model = $model;
            $this->doExecute();
        }

        protected function getModel(): AbstractModel
        {
            return $this->model;
        }

        abstract protected function doExecute();
    }
}

<?php

namespace Jukebox\Frontend\Handlers\Get\Ajax\Resolve
{

    use Jukebox\Framework\Handlers\TransformationHandlerInterface;
    use Jukebox\Framework\Models\AbstractModel;

    class TransformationHandler implements TransformationHandlerInterface
    {

        public function execute(AbstractModel $model): string
        {
            $data = $model->getData();
            if (empty($data)) {
                $data = ['status' => 404, 'message' => 'Not found'];
            }

            return json_encode($data);
        }
    }
}

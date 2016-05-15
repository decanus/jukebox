<?php

namespace Jukebox\API\Handlers\Get\NotFound
{

    use Jukebox\Framework\Handlers\TransformationHandlerInterface;
    use Jukebox\Framework\Http\StatusCodes\NotFound;
    use Jukebox\Framework\Models\AbstractModel;

    class TransformationHandler implements TransformationHandlerInterface
    {

        public function execute(AbstractModel $model): string
        {
            $model->setStatusCode(new NotFound);

            return json_encode([
                'status' => 404,
                'message' => 'Not found',
            ]);
        }
    }
}

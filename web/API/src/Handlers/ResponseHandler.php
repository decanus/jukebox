<?php

namespace Jukebox\API\Handlers
{

    use Jukebox\Framework\Handlers\ResponseHandlerInterface;
    use Jukebox\Framework\Http\Response\ResponseInterface;
    use Jukebox\Framework\Http\StatusCodes\NotFound;
    use Jukebox\Framework\Models\AbstractModel;

    class ResponseHandler implements ResponseHandlerInterface
    {
        /**
         * @param ResponseInterface $response
         * @param AbstractModel     $model
         */
        public function execute(ResponseInterface $response, AbstractModel $model)
        {
            if ($model->hasStatusCode()) {
                $response->setStatusCode($model->getStatusCode());

                if ($model->getStatusCode() instanceof NotFound) {
                    $response->setBody(json_encode(['status' => 404, 'message' => 'Not found']));
                }
            }
        }
    }
}

<?php

namespace Jukebox\API\Handlers\Get\Track
{

    use Jukebox\API\Queries\FetchTrackByIdQuery;
    use Jukebox\Framework\Handlers\QueryHandlerInterface;
    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\Http\StatusCodes\NotFound;
    use Jukebox\Framework\Models\AbstractModel;

    class QueryHandler implements QueryHandlerInterface
    {
        /**
         * @var FetchTrackByIdQuery
         */
        private $fetchTrackByIdQuery;

        public function __construct(FetchTrackByIdQuery $fetchTrackByIdQuery)
        {
            $this->fetchTrackByIdQuery = $fetchTrackByIdQuery;
        }

        public function execute(RequestInterface $request, AbstractModel $model)
        {
            $track = $this->fetchTrackByIdQuery->execute($request->getUri()->getExplodedPath()[2]);

            if (is_array($track)) {
                $model->setData($track);
                return;
            }

            $model->setStatusCode(new NotFound);
            $model->setData([
                'status' => 404,
                'message' => 'Not found',
            ]);
        }
    }
}

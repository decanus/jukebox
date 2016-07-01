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
            try {
                $model->setData($this->fetchTrackByIdQuery->execute($request->getUri()->getExplodedPath()[2]));
            } catch (\Throwable $e) {
                $model->setStatusCode(new NotFound);
            }
        }
    }
}

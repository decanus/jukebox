<?php

namespace Jukebox\API\Handlers\Get\Users\Playlist
{

    use Jukebox\API\Queries\FetchUserPlaylistQuery;
    use Jukebox\Framework\Handlers\QueryHandlerInterface;
    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\Http\StatusCodes\NotFound;
    use Jukebox\Framework\Models\AbstractModel;

    class QueryHandler implements QueryHandlerInterface
    {
        /**
         * @var FetchUserPlaylistQuery
         */
        private $fetchUserPlaylistQuery;

        public function __construct(FetchUserPlaylistQuery $fetchUserPlaylistQuery)
        {
            $this->fetchUserPlaylistQuery = $fetchUserPlaylistQuery;
        }

        public function execute(RequestInterface $request, AbstractModel $model)
        {
            $explodedPath = $request->getUri()->getExplodedPath();


            $playlist = $this->fetchUserPlaylistQuery->execute($explodedPath[2], $explodedPath[4]);

            if ($playlist === null) {
                $model->setStatusCode(new NotFound);
                return;
            }

            $model->setData($playlist->getArrayCopy());
        }
    }
}

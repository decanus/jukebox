<?php

namespace Jukebox\API\Handlers\Get\Users\Playlist
{

    use Jukebox\API\Queries\FetchPublicUserQuery;
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

        /**
         * @var FetchPublicUserQuery
         */
        private $fetchPublicUserQuery;

        public function __construct(
            FetchUserPlaylistQuery $fetchUserPlaylistQuery,
            FetchPublicUserQuery $fetchPublicUserQuery
        )
        {
            $this->fetchUserPlaylistQuery = $fetchUserPlaylistQuery;
            $this->fetchPublicUserQuery = $fetchPublicUserQuery;
        }

        public function execute(RequestInterface $request, AbstractModel $model)
        {
            $explodedPath = $request->getUri()->getExplodedPath();


            $playlist = $this->fetchUserPlaylistQuery->execute($explodedPath[2], $explodedPath[4]);
            $user = $this->fetchPublicUserQuery->execute($explodedPath[2]);

            if ($playlist === null) {
                $model->setStatusCode(new NotFound);
                return;
            }

            $playlist = $playlist->getArrayCopy();
            $playlist['owner'] = $user;
            $playlist['id'] = (string) $playlist['_id'];
            unset($playlist['_id']);

            $model->setData($playlist);
        }
    }
}

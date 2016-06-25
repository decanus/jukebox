<?php

namespace Jukebox\API\Handlers\Get\Users\Playlists
{

    use Jukebox\API\Queries\FetchPublicUserQuery;
    use Jukebox\API\Queries\FetchUserPlaylistsQuery;
    use Jukebox\Framework\Handlers\QueryHandlerInterface;
    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\Models\AbstractModel;

    class QueryHandler implements QueryHandlerInterface
    {
        /**
         * @var FetchUserPlaylistsQuery
         */
        private $fetchUserPlaylistsQuery;

        /**
         * @var FetchPublicUserQuery
         */
        private $fetchPublicUserQuery;

        public function __construct(
            FetchUserPlaylistsQuery $fetchUserPlaylistsQuery,
            FetchPublicUserQuery $fetchPublicUserQuery
        )
        {
            $this->fetchUserPlaylistsQuery = $fetchUserPlaylistsQuery;
            $this->fetchPublicUserQuery = $fetchPublicUserQuery;
        }

        public function execute(RequestInterface $request, AbstractModel $model)
        {
            $userId = $request->getUri()->getExplodedPath()[2];

            $playlists = $this->fetchUserPlaylistsQuery->execute($userId);
            $user = $this->fetchPublicUserQuery->execute($userId);

            foreach ($playlists as $key => $playlist) {
                $playlists[$key]['owner'] = $user;
                $playlists[$key]['id'] = (string) $playlist['_id'];
                unset($playlists[$key]['_id']);
            }

            $model->setData($playlists);

        }
    }
}

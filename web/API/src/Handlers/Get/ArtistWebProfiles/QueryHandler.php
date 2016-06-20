<?php

namespace Jukebox\API\Handlers\Get\ArtistWebProfiles
{

    use Jukebox\Framework\Backends\PostgreDatabaseBackend;
    use Jukebox\Framework\Handlers\QueryHandlerInterface;
    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\Http\StatusCodes\NotFound;
    use Jukebox\Framework\Models\AbstractModel;

    class QueryHandler implements QueryHandlerInterface
    {
        /**
         * @var PostgreDatabaseBackend
         */
        private $databaseBackend;

        public function __construct(PostgreDatabaseBackend $databaseBackend)
        {
            $this->databaseBackend = $databaseBackend;
        }

        public function execute(RequestInterface $request, AbstractModel $model)
        {
            $artist = $request->getUri()->getExplodedPath()[2];

            $data = $this->databaseBackend->fetchAll(
                'SELECT profile, profile_data FROM artist_web_profiles WHERE artist = :artist',
                [':artist' => $artist]
            );

            if (empty($data) || $data === false) {
                $model->setStatusCode(new NotFound);
                return;
            }

            $model->setData($data);
        }
    }
}

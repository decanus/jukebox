<?php

namespace Jukebox\API\Handlers\Get\ArtistImages
{

    use Elasticsearch\Common\Exceptions\Missing404Exception;
    use Jukebox\API\Queries\FetchArtistQuery;
    use Jukebox\Framework\Handlers\QueryHandlerInterface;
    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\Http\StatusCodes\NotFound;
    use Jukebox\Framework\Models\AbstractModel;

    class QueryHandler implements QueryHandlerInterface
    {
        /**
         * @var FetchArtistQuery
         */
        private $fetchArtistQuery;

        public function __construct(FetchArtistQuery $fetchArtistQuery)
        {
            $this->fetchArtistQuery = $fetchArtistQuery;
        }
        
        public function execute(RequestInterface $request, AbstractModel $model)
        {
            try {
                $artist = $this->fetchArtistQuery->execute($request->getUri()->getExplodedPath()[2]);
                $model->setData(['image' => $artist['image']]);
            } catch (Missing404Exception $e) {
                $model->setStatusCode(new NotFound);
            }
        }
    }
}

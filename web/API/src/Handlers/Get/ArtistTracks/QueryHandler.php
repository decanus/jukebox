<?php

namespace Jukebox\API\Handlers\Get\ArtistTracks
{

    use Jukebox\API\Queries\FetchTracksForArtistQuery;
    use Jukebox\Framework\Handlers\QueryHandlerInterface;
    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\Http\StatusCodes\NotFound;
    use Jukebox\Framework\Models\AbstractModel;

    class QueryHandler implements QueryHandlerInterface
    {
        /**
         * @var FetchTracksForArtistQuery
         */
        private $fetchTracksForArtistQuery;

        public function __construct(FetchTracksForArtistQuery $fetchTracksForArtistQuery)
        {
            $this->fetchTracksForArtistQuery = $fetchTracksForArtistQuery;
        }
        
        public function execute(RequestInterface $request, AbstractModel $model)
        {
            $size = 20;
            if ($request->hasParameter('size')) {
                $size = $request->getParameter('size');
            }

            $page = 1;
            if ($request->hasParameter('page')) {
                $page = $request->getParameter('page');
            }
            
            $tracks = $this->fetchTracksForArtistQuery->execute($request->getUri()->getExplodedPath()[2], $size, $page);

            if (!empty($tracks)) {
                $model->setData($tracks);
                return;
            }

            $model->setStatusCode(new NotFound);
        }
    }
}

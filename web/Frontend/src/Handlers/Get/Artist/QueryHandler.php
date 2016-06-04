<?php

namespace Jukebox\Frontend\Handlers\Get\Artist
{

    use Jukebox\Framework\DataPool\DataPoolReader;
    use Jukebox\Framework\Handlers\QueryHandlerInterface;
    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\Models\AbstractModel;
    use Jukebox\Framework\Rest\JukeboxRestManager;

    class QueryHandler implements QueryHandlerInterface
    {
        /**
         * @var DataPoolReader
         */
        private $dataPoolReader;

        /**
         * @var JukeboxRestManager
         */
        private $jukeboxRestManager;

        public function __construct(DataPoolReader $dataPoolReader, JukeboxRestManager $jukeboxRestManager)
        {
            $this->dataPoolReader = $dataPoolReader;
            $this->jukeboxRestManager = $jukeboxRestManager;
        }

        public function execute(RequestInterface $request, AbstractModel $model)
        {
            $id = $this->dataPoolReader->getArtistIdForPath($request->getUri()->getPath());

            $artist = $this->jukeboxRestManager->getArtistById($id);

            if ($artist->getResponseCode() !== 200) {
                return;
            }

            $model->setArtist($artist->getDecodedJsonResponse());
            $model->setTracks($this->jukeboxRestManager->getTracksByArtistId($id)->getDecodedJsonResponse());
        }
    }
}

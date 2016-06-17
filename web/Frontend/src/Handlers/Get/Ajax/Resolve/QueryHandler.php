<?php

namespace Jukebox\Frontend\Handlers\Get\Ajax\Resolve
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

        public function __construct(
            DataPoolReader $dataPoolReader,
            JukeboxRestManager $jukeboxRestManager
        )
        {
            $this->dataPoolReader = $dataPoolReader;
            $this->jukeboxRestManager = $jukeboxRestManager;
        }

        public function execute(RequestInterface $request, AbstractModel $model)
        {
            if (!$request->hasParameter('path')) {
                return;
            }

            $path = $request->getParameter('path');

            if ($this->dataPoolReader->hasArtistIdForPath($path)) {
                $model->setData($this->jukeboxRestManager->getArtistById($this->dataPoolReader->getArtistIdForPath($path))->getDecodedJsonResponse());
                return;
            }

            if ($this->dataPoolReader->hasTrackIdForPath($path)) {
                $model->setData($this->jukeboxRestManager->getTrackById($this->dataPoolReader->getTrackIdForPath($path))->getDecodedJsonResponse());
            }
        }
    }
}

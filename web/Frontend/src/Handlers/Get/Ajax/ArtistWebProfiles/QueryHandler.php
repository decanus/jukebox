<?php

namespace Jukebox\Frontend\Handlers\Get\Ajax\ArtistWebProfiles
{

    use Jukebox\Framework\Handlers\QueryHandlerInterface;
    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\Models\AbstractModel;
    use Jukebox\Framework\Rest\JukeboxRestManager;

    class QueryHandler implements QueryHandlerInterface
    {

        /**
         * @var JukeboxRestManager
         */
        private $jukeboxRestManager;

        public function __construct(JukeboxRestManager $jukeboxRestManager)
        {
            $this->jukeboxRestManager = $jukeboxRestManager;
        }

        public function execute(RequestInterface $request, AbstractModel $model)
        {
            try {
                $model->setData($this->jukeboxRestManager->getWebProfilesByArtistId($request->getParameter('artistId'))->getDecodedJsonResponse());
            } catch (\Throwable $e) {
                return;
            }
        }
    }
}

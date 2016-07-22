<?php

namespace Jukebox\Frontend\Handlers\Get\Me
{

    use Jukebox\Framework\Handlers\QueryHandlerInterface;
    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\Models\AbstractModel;
    use Jukebox\Framework\Rest\JukeboxRestManager;
    use Jukebox\Frontend\Session\SessionData;

    class QueryHandler implements QueryHandlerInterface
    {
        /**
         * @var SessionData
         */
        private $sessionData;

        /**
         * @var JukeboxRestManager
         */
        private $jukeboxRestManager;

        public function __construct(SessionData $sessionData, JukeboxRestManager $jukeboxRestManager)
        {
            $this->sessionData = $sessionData;
            $this->jukeboxRestManager = $jukeboxRestManager;
        }

        public function execute(RequestInterface $request, AbstractModel $model)
        {

            try {
                $accessToken = $this->sessionData->getAccessToken();

                $model->setData(
                    $this->jukeboxRestManager->me($accessToken)->getDecodedJsonResponse()
                );
            } catch (\Throwable $e) {
                $model->setData(
                    []
                );
            }
        }
    }
}

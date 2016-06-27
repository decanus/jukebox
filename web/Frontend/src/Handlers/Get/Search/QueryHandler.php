<?php

namespace Jukebox\Frontend\Handlers\Get\Search
{

    use Jukebox\Framework\Handlers\QueryHandlerInterface;
    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\Logging\LoggerAware;
    use Jukebox\Framework\Logging\LoggerAwareTrait;
    use Jukebox\Framework\Models\AbstractModel;
    use Jukebox\Framework\Rest\JukeboxRestManager;

    class QueryHandler implements QueryHandlerInterface, LoggerAware
    {
        use LoggerAwareTrait;

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

                if (!$request->hasParameter('q')) {
                    return;
                }

                $type = 'everything';
                if ($request->hasParameter('type')) {
                    $type = $request->getParameter('type');
                }

                $response = $this->jukeboxRestManager->search($request->getParameter('q'), 20, 1, $type);

                if ($response->getResponseCode() !== 200) {
                    return;
                }

                $model->setSearchResults($response->getDecodedJsonResponse());
            } catch (\Throwable $e) {
                $this->getLogger()->critical($e);
            }

        }
    }
}

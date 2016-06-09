<?php

namespace Jukebox\Frontend\Handlers\Get\Ajax\Search
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
            if (!$request->hasParameter('query')) {
                return;
            }

            $size = 20;
            if ($request->hasParameter('size')) {
                $size = $request->getParameter('size');
            }

            $page = 1;
            if ($request->hasParameter('page')) {
                $page = $request->getParameter('page');
            }

            try {
                $response = $this->jukeboxRestManager->search($request->getParameter('query'), $size, $page);

                if ($response->getResponseCode() !== 200) {
                    return;
                }

                $model->setData($response->getDecodedJsonResponse());

            } catch (\Throwable $e) {
                // @todo
            }
        }
    }
}

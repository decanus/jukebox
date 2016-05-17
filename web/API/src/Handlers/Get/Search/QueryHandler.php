<?php

namespace Jukebox\API\Handlers\Get\Search
{

    use Jukebox\Framework\Handlers\QueryHandlerInterface;
    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\Http\StatusCodes\BadRequest;
    use Jukebox\Framework\Models\AbstractModel;
    use Jukebox\Search\YoutubeSearch;

    class QueryHandler implements QueryHandlerInterface
    {
        /**
         * @var YoutubeSearch
         */
        private $search;

        /**
         * @param YoutubeSearch $search
         */
        public function __construct(YoutubeSearch $search)
        {
            $this->search = $search;
        }

        public function execute(RequestInterface $request, AbstractModel $model)
        {
            if (!$request->hasParameter('query')) {
                $model->setData(['errors' => ['message' => 'Missing required parameters']]);
                $model->setStatusCode(new BadRequest);
                return;
            }

            $model->setData($this->search->search($request->getParameter('query')));
        }
    }
}

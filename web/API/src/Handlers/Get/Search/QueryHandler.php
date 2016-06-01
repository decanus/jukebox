<?php

namespace Jukebox\API\Handlers\Get\Search
{
    use Jukebox\API\Backends\SearchBackend;
    use Jukebox\Framework\Handlers\QueryHandlerInterface;
    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\Http\StatusCodes\BadRequest;
    use Jukebox\Framework\Models\AbstractModel;

    class QueryHandler implements QueryHandlerInterface
    {
        /**
         * @var SearchBackend
         */
        private $searchBackend;

        public function __construct(SearchBackend $searchBackend)
        {
            $this->searchBackend = $searchBackend;
        }

        public function execute(RequestInterface $request, AbstractModel $model)
        {
            if (!$request->hasParameter('query')) {
                $model->setData(['errors' => ['message' => 'Missing required parameters']]);
                $model->setStatusCode(new BadRequest);
                return;
            }

            $params = [
                'query' => [
                    'match' => [
                        'title' => $request->getParameter('query')
                    ]
                ]
            ];

            $model->setData($this->searchBackend->search('tracks', $params));
        }
    }
}

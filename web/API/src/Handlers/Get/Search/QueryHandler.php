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

            if (trim($request->getParameter('query')) === '') {
                return;
            }

            $params = [
                'query' => [
                    'multi_match' => [
                        'query' => $request->getParameter('query'),
                        'fields' => ['name', 'title', 'artists.name.lower_case_sort'],
                        'type' => 'phrase_prefix'
                    ]
                ]
            ];

            $model->setData($this->searchBackend->search('tracks,artists', $params));
        }
    }
}

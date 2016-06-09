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
                        'fields' => [
                            'name^50',
                            'title^10',
                            'title.snowball^2',
                            'title.shingle^2',
                            'title.ngram^2',
                            'artists.name^2',
                            'artists.name.ngrams^2',
                            'name.snowball',
                            'name.shingle',
                            'name.ngram',
                            'name.name^10'
                        ],
                    ]
                ]
            ];

            $size = 20;
            if ($request->hasParameter('size')) {
                $size = $request->getParameter('size');
            }

            $page = 1;
            if ($request->hasParameter('page')) {
                $page = $request->getParameter('page');
            }

            $model->setData($this->searchBackend->search('tracks,artists', $params, $size, $page));
        }
    }
}

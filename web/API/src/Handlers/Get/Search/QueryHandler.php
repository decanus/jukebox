<?php

namespace Jukebox\API\Handlers\Get\Search
{

    use Elasticsearch\Client;
    use Jukebox\Framework\Handlers\QueryHandlerInterface;
    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\Http\StatusCodes\BadRequest;
    use Jukebox\Framework\Models\AbstractModel;

    class QueryHandler implements QueryHandlerInterface
    {
        /**
         * @var Client
         */
        private $client;

        public function __construct(Client $client)
        {
            $this->client = $client;
        }

        public function execute(RequestInterface $request, AbstractModel $model)
        {
            if (!$request->hasParameter('query')) {
                $model->setData(['errors' => ['message' => 'Missing required parameters']]);
                $model->setStatusCode(new BadRequest);
                return;
            }

            $params = [
                'index' => '20160530-2130',
                'type' => 'tracks',
                'body' => [
                    'query' => [
                        'match' => [
                            'title' => $request->getParameter('query')
                        ]
                    ]
                ]
            ];

            $model->setData($this->client->search($params)['hits']['hits']);
        }
    }
}

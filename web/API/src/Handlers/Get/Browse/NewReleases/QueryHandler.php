<?php

namespace Jukebox\API\Handlers\Browse\NewReleases
{

    use Jukebox\API\Backends\SearchBackend;
    use Jukebox\Framework\Handlers\QueryHandlerInterface;
    use Jukebox\Framework\Http\Request\RequestInterface;
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
            $model->setData(
                $this->searchBackend->search(
                    'tracks',
                    ['sort' => ['release_date' => ['order' => 'desc']]]
                )
            );
        }
    }
}

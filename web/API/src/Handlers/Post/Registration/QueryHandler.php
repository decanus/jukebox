<?php

namespace Jukebox\API\Handlers\Post\Registration
{

    use Jukebox\API\Queries\FetchUserByEmailQuery;
    use Jukebox\Framework\Handlers\QueryHandlerInterface;
    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\Http\StatusCodes\BadRequest;
    use Jukebox\Framework\Http\StatusCodes\StatusCodeInterface;
    use Jukebox\Framework\Models\AbstractModel;
    use Jukebox\Framework\ValueObjects\Email;

    class QueryHandler implements QueryHandlerInterface
    {
        /**
         * @var FetchUserByEmailQuery
         */
        private $fetchUserByEmailQuery;

        /**
         * @var AbstractModel
         */
        private $model;

        public function __construct(FetchUserByEmailQuery $fetchUserByEmailQuery)
        {
            $this->fetchUserByEmailQuery = $fetchUserByEmailQuery;
        }
        
        public function execute(RequestInterface $request, AbstractModel $model)
        {
            $this->model = $model;

            try {
                $email = new Email($request->getParameter('email'));
            } catch (\Exception $e) {
                $this->setError(new BadRequest, 'Invalid email');
                return;
            }
            
            $user = $this->fetchUserByEmailQuery->execute($email);
            if ($user !== false) {
                $this->setError(new BadRequest, 'User exists with email');
                return;
            }
        }

        private function setError(StatusCodeInterface $statusCode, string $message)
        {
            $this->model->setStatusCode($statusCode);
            $this->model->setData(['errors' => ['message' => $message]]);
        }
    }
}

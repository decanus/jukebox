<?php

namespace Jukebox\Framework\Controllers
{

    use Jukebox\Framework\Handlers\CommandHandlerInterface;
    use Jukebox\Framework\Handlers\PostHandlerInterface;
    use Jukebox\Framework\Handlers\PreHandlerInterface;
    use Jukebox\Framework\Handlers\QueryHandlerInterface;
    use Jukebox\Framework\Handlers\ResponseHandlerInterface;
    use Jukebox\Framework\Handlers\TransformationHandlerInterface;
    use Jukebox\Framework\Http\Request\AbstractRequest;
    use Jukebox\Framework\Http\Response\AbstractResponse;
    use Jukebox\Framework\Models\AbstractModel;

    abstract class AbstractController implements ControllerInterface
    {

        /**
         * @var AbstractModel
         */
        private $model;

        /**
         * @var PreHandlerInterface
         */
        private $preHandler;

        /**
         * @var CommandHandlerInterface
         */
        private $commandHandler;

        /**
         * @var QueryHandlerInterface
         */
        private $queryHandler;
        
        /**
         * @var TransformationHandlerInterface
         */
        private $transformationHandler;

        /**
         * @var ResponseHandlerInterface
         */
        private $responseHandler;

        /**
         * @var PostHandlerInterface
         */
        private $postHandler;

        /**
         * @var AbstractResponse
         */
        private $response;
        
        public function __construct(
            AbstractModel $model,
            PreHandlerInterface $preHandler,
            CommandHandlerInterface $commandHandler,
            QueryHandlerInterface $queryHandler,
            TransformationHandlerInterface $transformationHandler,
            ResponseHandlerInterface $responseHandler,
            PostHandlerInterface $postHandler,
            AbstractResponse $response
        )
        {
            $this->model = $model;
            $this->preHandler = $preHandler;
            $this->commandHandler = $commandHandler;
            $this->queryHandler = $queryHandler;
            $this->transformationHandler = $transformationHandler;
            $this->responseHandler = $responseHandler;
            $this->postHandler = $postHandler;
            $this->response = $response;
        }

        public function execute(AbstractRequest $request): AbstractResponse
        {
            $this->preHandler->execute($request, $this->model);
            $this->queryHandler->execute($request, $this->model);
            $this->commandHandler->execute($request, $this->model);

            if (!$this->model->hasRedirect()) {
                $this->response->setBody($this->transformationHandler->execute($this->model));
            }

            $this->responseHandler->execute($this->response, $this->model);
            $this->postHandler->execute($this->model);
            return $this->response;
        }
    }
}

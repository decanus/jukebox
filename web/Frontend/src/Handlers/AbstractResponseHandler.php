<?php

namespace Jukebox\Frontend\Handlers
{

    use Jukebox\Framework\Handlers\ResponseHandlerInterface;
    use Jukebox\Framework\Http\Response\ResponseInterface;
    use Jukebox\Framework\Models\AbstractModel;

    abstract class AbstractResponseHandler implements ResponseHandlerInterface
    {
        /**
         * @var ResponseInterface
         */
        private $response;
        
        /**
         * @var AbstractModel
         */
        private $model;
//        /**
//         * @var IsSessionStartedQuery
//         */
//        private $isSessionStartedQuery;
//
//        /**
//         * @var FetchSessionCookieQuery
//         */
//        private $fetchSessionCookieQuery;
//
//        /**
//         * @param IsSessionStartedQuery   $isSessionStartedQuery
//         * @param FetchSessionCookieQuery $fetchSessionCookieQuery
//         */
//        public function __construct(
//            IsSessionStartedQuery $isSessionStartedQuery,
//            FetchSessionCookieQuery $fetchSessionCookieQuery
//        )
//        {
//            $this->isSessionStartedQuery = $isSessionStartedQuery;
//            $this->fetchSessionCookieQuery = $fetchSessionCookieQuery;
//        }
        /**
         * @param ResponseInterface $responseInterface
         * @param AbstractModel     $model
         */
        public function execute(ResponseInterface $responseInterface, AbstractModel $model)
        {
            $this->response = $responseInterface;
            $this->model = $model;
            $this->doExecute();
            if ($model->hasRedirect()) {
                $responseInterface->setRedirect($model->getRedirect());
            }
//            if (!$this->isSessionStartedQuery->execute()) {
//                $this->getResponse()->setCookie($this->fetchSessionCookieQuery->execute());
//            }
        }
        
        abstract protected function doExecute();
        
        /**
         * @return ResponseInterface
         */
        protected function getResponse(): ResponseInterface
        {
            return $this->response;
        }
        
        /**
         * @return AbstractModel
         */
        protected function getModel(): AbstractModel
        {
            return $this->model;
        }
    }
}

<?php

namespace Jukebox\Frontend\Handlers
{

    use Jukebox\Framework\Handlers\ResponseHandlerInterface;
    use Jukebox\Framework\Http\Response\ResponseInterface;
    use Jukebox\Framework\Models\AbstractModel;
    use Jukebox\Frontend\Session\Session;

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
        /**
         * @var Session
         */
        private $session;

        public function __construct(Session $session)
        {
            $this->session = $session;
        }

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

            if (!$this->session->isSessionStarted()) {
                $this->getResponse()->setCookie($this->session->getCookie());
            }
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

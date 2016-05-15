<?php

namespace Jukebox\API\ErrorHandlers
{

    use Jukebox\API\Exceptions\AbstractException;
    use Jukebox\Framework\ErrorHandlers\AbstractErrorHandler;

    class ProductionErrorHandler extends AbstractErrorHandler
    {

        /**
         * @param \Throwable $exception
         */
        public function handleException(\Throwable $exception)
        {
            $status = $this->getStatusCode($exception);
            http_response_code($status);
            header('Content-Type: application/json');

            $response = [
                'status' => $status,
                'message' => $this->getMessage($exception),
            ];

            echo json_encode($response);
            exit;
        }

        private function getStatusCode(\Throwable $exception)
        {
            if ($exception instanceof AbstractException) {
                return $exception->getStatusCode();
            }

            return 500;
        }

        private function getMessage(\Throwable $exception)
        {
            if ($exception instanceof AbstractException) {
                return $exception->getMessage();
            }

            return 'Internal Server Error';
        }

    }
}

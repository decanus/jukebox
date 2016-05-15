<?php

namespace Jukebox\API\Models
{

    use Jukebox\Framework\Http\StatusCodes\StatusCodeInterface;
    use Jukebox\Framework\Models\AbstractModel;

    class APIModel extends AbstractModel
    {
        /**
         * @var StatusCodeInterface
         */
        private $statusCode;

        private $data = [];

        public function setStatusCode(StatusCodeInterface $statusCode)
        {
            $this->statusCode = $statusCode;
        }

        public function hasStatusCode(): bool
        {
            return $this->statusCode instanceof StatusCodeInterface;
        }

        public function getStatusCode(): StatusCodeInterface
        {
            return $this->statusCode;
        }

        public function setData(array $data)
        {
            $this->data = $data;
        }

        public function getData(): array
        {
            return $this->data;
        }
    }
}

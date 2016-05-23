<?php

namespace Jukebox\Framework\Logging\Logs
{
    class ErrorLog implements LogInterface
    {
        private $exception;

        public function __construct(\Throwable $exception)
        {
            $this->exception = $exception;
        }

        public function getLog(): array
        {
            return [
                'level' => 'error',
                'code' => $this->exception->getCode(),
                'message' => $this->exception->getMessage(),
                'trace' => $this->exception->getTraceAsString(),
            ];
        }

        public function getMessage(): string
        {
            return $this->exception->getMessage();
        }
    }
}

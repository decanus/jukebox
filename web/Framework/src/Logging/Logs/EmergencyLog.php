<?php

namespace Jukebox\Framework\Logging\Logs
{
    class EmergencyLog implements LogInterface
    {
        private $exception;

        public function __construct(\Throwable $exception)
        {
            $this->exception = $exception;
        }

        public function getLog(): array
        {
            return [
                'level' => 'emergency',
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

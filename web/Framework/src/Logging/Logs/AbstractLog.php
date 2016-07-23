<?php

namespace Jukebox\Framework\Logging\Logs
{
    abstract class AbstractLog implements LogInterface
    {
        /**
         * @var \Throwable
         */
        private $exception;

        public function __construct(\Throwable $exception)
        {
            $this->exception = $exception;
        }

        public function getMessage(): string
        {
            return $this->exception->getMessage();
        }

        public function __toString(): string
        {
            $string = '';
            $e = $this->exception;
            do {
                $string .= get_class($e) . '(code: ' . $e->getCode() . '): ' . $e->getMessage() . ' at ' .
                    $e->getFile() . ':' . $e->getLine() .
                    PHP_EOL . 'Stacktrace:' . PHP_EOL .
                    $e->getTraceAsString() . PHP_EOL;

                $e = $e->getPrevious();
            } while ($e !== null);
            return $string;
        }
    }
}

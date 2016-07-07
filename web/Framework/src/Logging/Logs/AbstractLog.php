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
                $string .= 'Exception "' . get_class($e) . '"' .
                    ' thrown in: "' . $e->getFile() . '"' .
                    ' on line ' . $e->getLine() .
                    ' with message: "' . $e->getMessage() . '"' .
                    ' and errorcode ' . $e->getCode() . '.' .
                    PHP_EOL . 'Backtrace:' . PHP_EOL .
                    $e->getTraceAsString() . PHP_EOL .
                    '---------PREVIOUS--MARKER---------'. PHP_EOL;
                $e = $e->getPrevious();
            } while ($e !== null);
            return $string;
        }
    }
}

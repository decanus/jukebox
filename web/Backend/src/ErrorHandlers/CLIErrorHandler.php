<?php

namespace Jukebox\Backend\ErrorHandlers
{

    use Jukebox\Framework\ErrorHandlers\AbstractErrorHandler;

    class CLIErrorHandler extends AbstractErrorHandler
    {

        /**
         * @param \Throwable $exception
         */
        public function handleException(\Throwable $exception)
        {
            $string = '';
            $e = $exception;
            do {
                $string .= get_class($e) . '(code: ' . $e->getCode() . '): ' . $e->getMessage() . ' at ' .
                    $e->getFile() . ':' . $e->getLine() .
                    PHP_EOL . 'Stacktrace:' . PHP_EOL .
                    $e->getTraceAsString() . PHP_EOL;

                $e = $e->getPrevious();
            } while ($e !== null);

            echo $string;
        }
    }
}

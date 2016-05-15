<?php

namespace Jukebox\Framework\ErrorHandlers
{
    class DevelopmentErrorHandler extends AbstractErrorHandler
    {
        /**
         * @param \Throwable $exception
         */
        public function handleException(\Throwable $exception)
        {
            echo '<b>Exception:</b> ' . get_class($exception) . '<br />'
                . '<b>Location:</b> ' . $exception->getFile() . '<br />'
                . '<b>Line:</b> ' . $exception->getLine() . '<br />'
                . '<b>Message:</b> ' . $exception->getMessage() . '<br />';
            $current = $exception;
            while ($current = $current->getPrevious()) {
                echo '<h2>Caused by:</h2> <br />'
                    . '<b>Exception:</b> ' . get_class($current) . '<br />'
                    . '<b>Location:</b> ' . $current->getFile() . '<br />'
                    . '<b>Line:</b> ' . $current->getLine() . '<br />'
                    . '<b>Message:</b> ' . $current->getMessage() . '<br />';
            }
            echo '<hr color="black" />';
            foreach ($exception->getTrace() as $trace) {
                $this->printTrace($trace);
            }
        }

        /**
         * @param array $trace
         */
        private function printTrace($trace)
        {
            $file = 'native';
            $line = '?';
            if (isset($trace['file'])) {
                $file = $trace['file'];
            }
            if (isset($trace['line'])) {
                $line = $trace['line'];
            }
            echo '<b>File:</b> ' . $file
                . ' <b>Function:</b> ' . $trace['function']
                . ' <b>Line:</b>' . $line . '<br />';
        }
    }
}

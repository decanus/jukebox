<?php

namespace Jukebox\Framework\ErrorHandlers
{
    abstract class AbstractErrorHandler
    {
        public function register()
        {
            set_exception_handler([$this, 'handleException']);
            set_error_handler(array($this, 'handleError'), E_STRICT | E_NOTICE | E_WARNING | E_RECOVERABLE_ERROR | E_USER_ERROR);
        }

        public function __destruct()
        {
            restore_exception_handler();
        }

        /**
         * @param $errno
         * @param $errstr
         * @param $errfile
         * @param $errline
         *
         * @throws \ErrorException
         */
        public function handleError($errno, $errstr, $errfile, $errline)
        {
            throw new \ErrorException($errstr, -1, $errno, $errfile, $errline);
        }

        /**
         * @param \Throwable $exception
         */
        abstract public function handleException(\Throwable $exception);
    }
}

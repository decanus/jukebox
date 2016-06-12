<?php

namespace Jukebox\Framework\ErrorHandlers
{
    class ProductionErrorHandler extends AbstractErrorHandler
    {
        /**
         * @param \Throwable $exception
         */
        public function handleException(\Throwable $exception)
        {
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/error');
            die();
        }
    }
}

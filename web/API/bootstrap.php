<?php

namespace Jukebox\API
{

    use Jukebox\Framework\FrontController;

    require __DIR__ . '/src/autoload.php';
    require __DIR__ . '/../Framework/bootstrap.php';

    (new FrontController(new LiveBootstrapper()))->run()->send();
}
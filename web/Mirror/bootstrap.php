<?php

namespace Jukebox\Mirror
{

    require __DIR__ . '/src/autoload.php';
    require __DIR__ . '/../Framework/bootstrap.php';

    use Jukebox\Framework\FrontController;

    (new FrontController(new LiveBootstrapper))->run()->send();

}

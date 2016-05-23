<?php

namespace Jukebox\Backend
{

    use Jukebox\Backend\Bootstrapper\WorkerBootstrapper;

    require __DIR__ . '/bootstrap.php';

    $bootstrapper = new WorkerBootstrapper($argv);

    $factory = $bootstrapper->getFactory();
    $worker = $factory->createWorker();
    $worker->process();

}
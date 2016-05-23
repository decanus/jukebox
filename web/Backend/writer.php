<?php

namespace Jukebox\Backend
{

    use Jukebox\Backend\Bootstrapper\WriterBootstrapper;

    require __DIR__ . '/bootstrap.php';

    $bootstrapper = new WriterBootstrapper($argv);

    $factory = $bootstrapper->getFactory();
    $writer = $factory->createEventQueueWriter();
    $writer->add($factory->createEventLocator()->locate($bootstrapper->getRequest()));

}
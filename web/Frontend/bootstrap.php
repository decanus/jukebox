<?php

namespace Jukebox\Frontend
{

    use Jukebox\Framework\FrontController;

    (new FrontController(new LiveBootstrapper))->run()->send();

}

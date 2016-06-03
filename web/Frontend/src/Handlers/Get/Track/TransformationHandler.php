<?php

namespace Jukebox\Frontend\Handlers\Get\Track
{

    use Jukebox\Frontend\Handlers\Get\AbstractTransformationHandler;

    class TransformationHandler extends AbstractTransformationHandler
    {

        protected function doExecute()
        {
            $main = $this->getTemplate()->queryOne('//html:main');
            $noscript = $main->appendElement('noscript');
            $noscript->appendElement('div', 'foo');
        }
    }
}

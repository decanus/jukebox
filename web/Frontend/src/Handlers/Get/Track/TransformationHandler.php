<?php

namespace Jukebox\Frontend\Handlers\Get\Track
{

    use Jukebox\Frontend\Handlers\Get\AbstractTransformationHandler;

    class TransformationHandler extends AbstractTransformationHandler
    {

        protected function doExecute()
        {
            $main = $this->getTemplate()->queryOne('//html:main');

            try {

                $track = $this->getModel()->getTrack();

                $noscript = $main->appendElement('noscript');
                $recording = $noscript->appendElement('article');
                $recording->setAttribute('itemscope', '');
                $recording->setAttribute('itemtype', 'http://schema.org/MusicRecording');

                $name = $recording->appendElement('h1');
                $name->setAttribute('itemprop', 'name');

                $link = $name->appendElement('a');
                $link->setAttribute('itemprop', 'url');
                $link->setAttribute('href', $track['permalink']);
                $link->appendTextNode($track['title']);

            } catch (\Throwable $e) {
                // @todo
            }

        }
    }
}

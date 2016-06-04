<?php

namespace Jukebox\Frontend\Handlers\Get\Artist
{

    use Jukebox\Frontend\Handlers\Get\AbstractTransformationHandler;

    class TransformationHandler extends AbstractTransformationHandler
    {

        protected function doExecute()
        {
            $main = $this->getTemplate()->queryOne('//html:main');

            try {

                $artist = $this->getModel()->getArtist();

                $noscript = $main->appendElement('noscript');

                $musicGroup = $noscript->appendElement('article');
                $musicGroup->setAttribute('itemscope', '');
                $musicGroup->setAttribute('itemtype', 'http://schema.org/MusicGroup');

                $name = $musicGroup->appendElement('h1');
                $name->setAttribute('itemprop', 'name');

                $link = $name->appendElement('a');
                $link->setAttribute('itemprop', 'url');
                $link->setAttribute('href', $artist['permalink']);
                $link->appendTextNode($artist['name']);

            } catch (\Throwable $e) {
                // @todo log somewhere
            }

        }
    }
}

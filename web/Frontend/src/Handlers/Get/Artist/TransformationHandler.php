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

                $tracks = $this->getModel()->getTracks();

                foreach ($tracks as $track) {

                    $recording = $musicGroup->appendElement('article');
                    $recording->setAttribute('itemprop', 'track');
                    $recording->setAttribute('itemscope', '');
                    $recording->setAttribute('itemtype', 'http://schema.org/MusicRecording');

                    $name = $recording->appendElement('h2');
                    $name->setAttribute('itemprop', 'name');

                    $link = $name->appendElement('a');
                    $link->setAttribute('itemprop', 'url');
                    $link->setAttribute('href', $track['permalink']);
                    $link->appendTextNode($track['title']);

                    $duration = $recording->appendElement('meta');
                    $duration->setAttribute('itemprop', 'duration');
                    $duration->setAttribute('content',  'P' . floor($track['duration'] / 1000) . 'S');
                }

            } catch (\Throwable $e) {
                // @todo log somewhere
            }

        }
    }
}

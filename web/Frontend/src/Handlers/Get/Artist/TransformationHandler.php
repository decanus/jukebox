<?php

namespace Jukebox\Frontend\Handlers\Get\Artist
{

    use Jukebox\Frontend\Handlers\Get\AbstractTransformationHandler;

    class TransformationHandler extends AbstractTransformationHandler
    {

        protected function doExecute()
        {
            $template = $this->getTemplate();
            $main = $template->queryOne('//html:main');

            try {

                $artist = $this->getModel()->getArtist();

                $template->queryOne('/html:html/html:head/html:title')->appendTextNode('Jukebox Ninja - ' . $artist['name']);

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

                $template->queryOne('//html:script[@id="models"]')->appendChild(
                    $template->createTextNode('window.__$models = ' . json_encode([$artist]))
                );
                
                $tracks = $this->getModel()->getTracks();

                if (!isset($tracks['results'])) {
                    return;
                }

                foreach ($tracks['results'] as $track) {

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

<?php

namespace Jukebox\Frontend\Handlers\Get\Track
{

    use Jukebox\Frontend\Handlers\Get\AbstractTransformationHandler;

    class TransformationHandler extends AbstractTransformationHandler
    {

        protected function doExecute()
        {
            $template = $this->getTemplate();
            $main = $template->queryOne('//html:main');

            try {

                $track = $this->getModel()->getTrack();

                $template->queryOne('/html:html/html:head/html:title')->appendTextNode('Jukebox Ninja - ' . $track['title']);

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

                $artist = $recording->appendElement('div');
                $artist->setAttribute('itemtype', 'http://schema.org/MusicGroup');
                $artist->setAttribute('itemprop', 'byArtist');
                $artist->setAttribute('itemscope', '');

                $duration = $recording->appendElement('meta');
                $duration->setAttribute('itemprop', 'duration');
                $duration->setAttribute('content',  'P' . floor($track['duration'] / 1000) . 'S');

                foreach ($track['artists'] as $item) {
                    if ($item['role'] === 'main') {
                        $name = $artist->appendElement('meta');
                        $name->setAttribute('itemprop', 'name');
                        $name->setAttribute('content', $item['name']);
                        break;
                    }
                }

            } catch (\Throwable $e) {
                // @todo
            }

        }
    }
}

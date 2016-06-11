<?php

namespace Jukebox\Frontend\Handlers\Get\Search
{

    use Jukebox\Frontend\Handlers\Get\AbstractTransformationHandler;

    class TransformationHandler extends AbstractTransformationHandler
    {

        protected function doExecute()
        {
            try {
                $searchResults = $this->getModel()->getSearchResults();
                if ($searchResults === []) {
                    return;
                }

                $template = $this->getTemplate();
                $noscript = $template->queryOne('//html:body')->appendElement('noscript');
                $list = $noscript->appendElement('ul');

                foreach ($searchResults['results'] as $result) {
                    $item = $list->appendElement('li');

                    if ($result['type'] === 'artists') {
                        $value = $result['name'];
                    } else {
                        $value = $result['title'];
                    }

                    $link = $item->appendElement('a', $value);
                    $link->setAttribute('href', $result['permalink']);

                }

                $searchResults['type'] = 'results';
                $template->queryOne('//html:body')->appendElement('script', '__$loadModel(' . json_encode($searchResults) . ')');
            } catch (\Throwable $e) {
                // do nothing
            }
        }
    }
}

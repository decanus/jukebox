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

                $requestUri = $this->getModel()->getRequestUri();
                $searchType = 'everything';

                if ($requestUri->hasParameter('type')) {
                    $searchType = $requestUri->getParameter('type');
                }

                $searchResults['type'] = 'results';
                $searchResults['id'] = $requestUri->getParameter('q') . ':' . $searchType;

                $template->queryOne('//html:script[@id="models"]')->appendChild(
                    $template->createTextNode('window.__$models = ' . json_encode([$searchResults]))
                );
            } catch (\Throwable $e) {
                // do nothing
            }
        }
    }
}

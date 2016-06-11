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

                $searchResults['type'] = 'results';
                $template = $this->getTemplate();
                $template->queryOne('//html:body')->appendElement('script', '__$loadModel(' . json_encode($searchResults) . ')');
            } catch (\Throwable $e) {
                // do nothing
            }
        }
    }
}

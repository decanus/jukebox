<?php

namespace Jukebox\Frontend\Transformations
{

    use Jukebox\Framework\Models\AbstractModel;
    use Jukebox\Frontend\Models\ArtistPageModel;
    use Jukebox\Frontend\Models\TrackPageModel;
    use TheSeer\fDOM\fDOMDocument;

    class MetaTagsTransformation
    {
        /**
         * @var fDOMDocument
         */
        private $template;

        public function transform(fDOMDocument $template, AbstractModel $model)
        {
            $this->template = $template;

            if ($model instanceof TrackPageModel) {
                $this->handleTrackPage($model);
            }

            if ($model instanceof ArtistPageModel) {
                $this->handleArtistPage($model);
            }
        }

        private function handleTrackPage(TrackPageModel $model)
        {
            $this->template->queryOne('/html:html/html:head/html:title')->setAttribute('content', $model->getMetaTitle());
            $this->template->queryOne('/html:html/html:head/html:meta[@name="description"]')->setAttribute('content', $model->getMetaDescription());
        }

        private function handleArtistPage(ArtistPageModel $model)
        {
            $artist = $model->getArtist();
            $this->template->queryOne('/html:html/html:head/html:title')->setAttribute('content', 'Jukebox Ninja - ' . $artist['name']);
            $this->template->queryOne('/html:html/html:head/html:meta[@name="description"]')->setAttribute('content', 'Jukebox Ninja - Listen to great artists like ' . $artist['name']);
        }
    }
}

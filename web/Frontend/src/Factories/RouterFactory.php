<?php

namespace Jukebox\Frontend\Factories
{

    use Jukebox\Framework\Factories\AbstractFactory;

    class RouterFactory extends AbstractFactory
    {
        public function createStaticPageRouter(): \Jukebox\Frontend\Routers\StaticPageRouter
        {
            return new \Jukebox\Frontend\Routers\StaticPageRouter($this->getMasterFactory());
        }

        public function createErrorPageRouter(): \Jukebox\Frontend\Routers\ErrorPageRouter
        {
            return new \Jukebox\Frontend\Routers\ErrorPageRouter($this->getMasterFactory());
        }

        public function createTrackPageRouter(): \Jukebox\Frontend\Routers\TrackPageRouter
        {
            return new \Jukebox\Frontend\Routers\TrackPageRouter($this->getMasterFactory(), $this->getMasterFactory()->createDataPoolReader());
        }

        public function createArtistPageRouter(): \Jukebox\Frontend\Routers\ArtistPageRouter
        {
            return new \Jukebox\Frontend\Routers\ArtistPageRouter($this->getMasterFactory(), $this->getMasterFactory()->createDataPoolReader());
        }

        public function createAjaxRequestRouter(): \Jukebox\Frontend\Routers\AjaxRequestRouter
        {
            return new \Jukebox\Frontend\Routers\AjaxRequestRouter($this->getMasterFactory());
        }

        public function createSearchPageRouter(): \Jukebox\Frontend\Routers\SearchPageRouter
        {
            return new \Jukebox\Frontend\Routers\SearchPageRouter($this->getMasterFactory());
        }

        public function createPostRequestRouter(): \Jukebox\Frontend\Routers\PostRequestRouter
        {
            return new \Jukebox\Frontend\Routers\PostRequestRouter($this->getMasterFactory());
        }
    }
}

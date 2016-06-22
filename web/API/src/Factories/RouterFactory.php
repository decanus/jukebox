<?php

namespace Jukebox\API\Factories
{

    use Jukebox\Framework\Factories\AbstractFactory;

    class RouterFactory extends AbstractFactory
    {
        public function createArtistsRouter(): \Jukebox\API\Routers\ArtistsRouter
        {
            $router = new \Jukebox\API\Routers\ArtistsRouter($this->getMasterFactory()->createAccessControl());
            $router->addEndpointHandler(new \Jukebox\API\Endpoints\v1\Artists\GetArtistEndpoint($this->getMasterFactory()));
            $router->addEndpointHandler(new \Jukebox\API\Endpoints\v1\Artists\Tracks\GetArtistTracksEndpoint($this->getMasterFactory()));
            $router->addEndpointHandler(new \Jukebox\API\Endpoints\v1\Artists\Images\GetArtistImagesEndpoint($this->getMasterFactory()));
            $router->addEndpointHandler(new \Jukebox\API\Endpoints\v1\Artists\WebProfiles\GetArtistWebProfilesEndpoint($this->getMasterFactory()));
            return $router;
        }

        public function createTracksRouter(): \Jukebox\API\Routers\TracksRouter
        {
            $router = new \Jukebox\API\Routers\TracksRouter($this->getMasterFactory()->createAccessControl());
            $router->addEndpointHandler(new \Jukebox\API\Endpoints\v1\Tracks\GetTrackEndpoint($this->getMasterFactory()));
            return $router;
        }

        public function createSearchRouter(): \Jukebox\API\Routers\SearchRouter
        {
            $router = new \Jukebox\API\Routers\SearchRouter($this->getMasterFactory()->createAccessControl());
            $router->addEndpointHandler(new \Jukebox\API\Endpoints\v1\SearchEndpoint($this->getMasterFactory()));
            return $router;
        }

        public function createRegistrationRouter(): \Jukebox\API\Routers\RegistrationRouter
        {
            $router = new \Jukebox\API\Routers\RegistrationRouter($this->getMasterFactory()->createAccessControl());
            $router->addEndpointHandler(new \Jukebox\API\Endpoints\v1\RegistrationEndpoint($this->getMasterFactory()));
            return $router;
        }

        public function createAuthenticationRouter(): \Jukebox\API\Routers\AuthenticationRouter
        {
            $router = new \Jukebox\API\Routers\AuthenticationRouter($this->getMasterFactory()->createAccessControl());
            $router->addEndpointHandler(new \Jukebox\API\Endpoints\v1\AuthenticationEndpoint($this->getMasterFactory()));
            return $router;
        }

        public function createMyRouter(): \Jukebox\API\Routers\MyRouter
        {
            $router = new \Jukebox\API\Routers\MyRouter($this->getMasterFactory()->createAccessControl());
            $router->addEndpointHandler(new \Jukebox\API\Endpoints\v1\Me\GetMyPlaylistsEndpoint($this->getMasterFactory()));
            return $router;
        }
    }
}

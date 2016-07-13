<?php

namespace Jukebox\Framework\Rest
{

    use Jukebox\Framework\Curl\Curl;
    use Jukebox\Framework\Curl\Response;
    use Jukebox\Framework\ValueObjects\AccessToken;
    use Jukebox\Framework\ValueObjects\Email;
    use Jukebox\Framework\ValueObjects\Password;
    use Jukebox\Framework\ValueObjects\Uri;
    use Jukebox\Framework\ValueObjects\Username;

    class JukeboxRestManager
    {
        /**
         * @var Curl
         */
        private $curl;

        /**
         * @var Uri
         */
        private $uri;

        /**
         * @var string
         */
        private $key;

        /**
         * @var AccessToken
         */
        private $accessToken = null;

        public function __construct(Curl $curl, Uri $uri, string $key)
        {
            $this->curl = $curl;
            $this->uri = $uri;
            $this->key = $key;
        }

        public function getTrackById(string $id): Response
        {
            return $this->curl->get($this->buildUri('/v1/tracks/' . $id), ['key' => $this->key]);
        }

        public function getArtistById(string $id): Response
        {
            return $this->curl->get($this->buildUri('/v1/artists/' . $id), ['key' => $this->key]);
        }

        public function getTracksByArtistId(string $id, int $size = 20, int $page = 1): Response
        {
            return $this->curl->get($this->buildUri('/v1/artists/' . $id . '/tracks'), ['key' => $this->key, 'size' => $size, 'page' => $page]);
        }

        public function getWebProfilesByArtistId(string $id): Response
        {
            return $this->curl->get($this->buildUri('/v1/artists/' . $id . '/web-profiles'), ['key' => $this->key]);
        }

        public function search(string $searchTerm, int $size, int $page, string $type = 'everything'): Response
        {
            return $this->curl->get(
                $this->buildUri('/v1/search'),
                ['key' => $this->key, 'query' => $searchTerm, 'size' => $size, 'page' => $page, 'type' => $type]
            );
        }

        public function login(Email $email, Password $password): Response
        {
            return $this->curl->post(
                $this->buildUri('/v1/authentication'),
                ['key' => $this->key, 'email' => (string) $email, 'password' => (string) $password]
            );
        }

        public function register(Email $email, Username $username, Password $password): Response
        {

            return $this->curl->post(
                $this->buildUri('/v1/authentication'),
                ['key' => $this->key, 'email' => (string) $email, 'password' => (string) $password, 'username' => $username]
            );
        }

        public function me(AccessToken $accessToken = null): Response
        {
            $token = null;
            if ($this->accessToken !== null) {
                $token = $this->accessToken;
            }

            if ($accessToken !== null) {
                $token = $accessToken;
            }

            if ($token === null) {
                throw new \Exception('No access token provided');
            }

            return $this->curl->get(
                $this->buildUri('/v1/me'),
                ['key' => $this->key, 'access_token' => (string) $token]
            );
        }

        public function setAccessToken(AccessToken $accessToken)
        {
            $this->accessToken = $accessToken;
        }

        private function buildUri(string $path): Uri
        {
            return new Uri($this->uri . $path);
        }
    }
}

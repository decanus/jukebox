<?php

namespace Jukebox\Frontend\Commands
{

    use Jukebox\Framework\Rest\JukeboxRestManager;
    use Jukebox\Framework\ValueObjects\AccessToken;
    use Jukebox\Framework\ValueObjects\Email;
    use Jukebox\Framework\ValueObjects\Password;
    use Jukebox\Frontend\DataObjects\Accounts\RegisteredAccount;
    use Jukebox\Frontend\Session\SessionData;

    class LoginCommand
    {
        /**
         * @var JukeboxRestManager
         */
        private $jukeboxRestManager;
        
        /**
         * @var SessionData
         */
        private $sessionData;

        public function __construct(
            JukeboxRestManager $jukeboxRestManager,
            SessionData $sessionData
        )
        {
            $this->jukeboxRestManager = $jukeboxRestManager;
            $this->sessionData = $sessionData;
        }

        public function execute(Email $email, Password $password): array
        {
            $loginResponse = $this->jukeboxRestManager->login($email, $password);

            if ($loginResponse->getResponseCode() !== 200) {
                throw new \InvalidArgumentException('Login Failed');
            }

            $decodedResponse = $loginResponse->getDecodedJsonResponse();
            if (!isset($decodedResponse['access_token'])) {
                throw new \RuntimeException('No access token received');
            }

            $this->sessionData->setAccount(new RegisteredAccount);

            $accessToken = new AccessToken($decodedResponse['access_token']);
            $this->sessionData->setAccessToken($accessToken);

            return $this->jukeboxRestManager->me($accessToken)->getDecodedJsonResponse();
        }
    }
}

<?php

namespace Jukebox\Frontend\Commands
{

    use Jukebox\Framework\Rest\JukeboxRestManager;
    use Jukebox\Framework\ValueObjects\Email;
    use Jukebox\Framework\ValueObjects\Password;
    use Jukebox\Framework\ValueObjects\Username;

    class RegistrationCommand
    {
        /**
         * @var JukeboxRestManager
         */
        private $jukeboxRestManager;

        public function __construct(JukeboxRestManager $jukeboxRestManager)
        {
            $this->jukeboxRestManager = $jukeboxRestManager;
        }

        public function execute(Email $email, Username $username, Password $password): bool
        {
            $response = $this->jukeboxRestManager->register($email, $username, $password);

            if ($response->getResponseCode() === 201) {
                return true;
            }

            $data = $response->getDecodedJsonResponse();

            if ($data['message'] === 'User exists with email') {
                throw new \InvalidArgumentException('User already exists with email');
            }

            if ($data['message'] === 'User exists with username') {
                throw new \InvalidArgumentException('User already exists with username');
            }

            return false;
        }
    }
}

<?php

namespace Jukebox\Frontend\Commands
{

    use Jukebox\Framework\Rest\JukeboxRestManager;
    use Jukebox\Framework\ValueObjects\Email;
    use Jukebox\Framework\ValueObjects\Password;
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

        }
    }
}

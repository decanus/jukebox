<?php

namespace Jukebox\Frontend\Commands
{

    use Jukebox\Framework\Rest\JukeboxRestManager;
    use Jukebox\Framework\ValueObjects\Email;
    use Jukebox\Framework\ValueObjects\Password;

    class LoginCommand
    {
        /**
         * @var JukeboxRestManager
         */
        private $jukeboxRestManager;

        public function __construct(JukeboxRestManager $jukeboxRestManager)
        {
            $this->jukeboxRestManager = $jukeboxRestManager;
        }

        public function execute(Email $email, Password $password): array 
        {

        }
    }
}

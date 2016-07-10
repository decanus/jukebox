<?php

namespace Jukebox\Frontend\Commands
{

    use Jukebox\Framework\Rest\JukeboxRestManager;

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

        public function execute()
        {
            
        }
    }
}

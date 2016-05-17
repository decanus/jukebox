<?php

namespace Jukebox\Backend\EventHandlers\Import
{

    use Jukebox\Backend\EventHandlers\EventHandlerInterface;
    use Jukebox\Backend\Services\Vevo;

    class InitialVevoArtistsImportEventHandler implements EventHandlerInterface
    {
        /**
         * @var Vevo
         */
        private $vevo;

        public function __construct(Vevo $vevo)
        {
            $this->vevo = $vevo;
        }


        public function execute()
        {
            try {
                $artists = $this->vevo->getArtists();

                $data = $artists->getDecodedJsonResponse();

                for ($i = 2; $i <= $data['paging']['pages']; $i++) {
                    var_dump($this->vevo->getArtists($i));
                }
                
            } catch (\Exception $e) {
                // @todo handle
            }
        }
    }
}

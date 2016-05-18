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
                $artists = $this->vevo->getArtists()->getDecodedJsonResponse();

                foreach ($artists['artists'] as $artist) {
                    $this->handleArtist($artist);
                }

                $pages = $artists['paging']['pages'];
                for ($i = 2; $i <= $pages; $i++) {
                    $artists = $this->vevo->getArtists($i)->getDecodedJsonResponse()['artists'];

                    foreach ($artists as $artist) {
                        $this->handleArtist($artist);
                    }
                }

            } catch (\Exception $e) {
                var_dump($e->getMessage());
                // @todo handle
            }
        }

        public function handleArtist(array $artist)
        {
            var_dump($artist['name']);
        }
    }
}

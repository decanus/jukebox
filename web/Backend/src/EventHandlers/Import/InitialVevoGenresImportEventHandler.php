<?php

namespace Jukebox\Backend\EventHandlers\Import
{
    use Jukebox\Backend\EventHandlers\EventHandlerInterface;
    use Jukebox\Backend\Services\Vevo;

    class InitialVevoGenresImportEventHandler implements EventHandlerInterface
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
                $genres = $this->vevo->getGenres();
                
                var_dump($genres->getDecodedJsonResponse());
            } catch (\Exception $e) {
                // @todo handle
            }
        }
    }

}

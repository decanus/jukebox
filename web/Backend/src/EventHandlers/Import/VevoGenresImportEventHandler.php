<?php

namespace Jukebox\Backend\EventHandlers\Import {

    use Jukebox\Backend\EventHandlers\Commands\InsertGenreCommand;
    use Jukebox\Backend\EventHandlers\EventHandlerInterface;
    use Jukebox\Backend\Services\Vevo;

    class VevoGenresImportEventHandler implements EventHandlerInterface
    {
        /**
         * @var Vevo
         */
        private $vevo;

        /**
         * @var InsertGenreCommand
         */
        private $insertGenreCommand;

        public function __construct(Vevo $vevo, InsertGenreCommand $insertGenreCommand)
        {
            $this->vevo = $vevo;
            $this->insertGenreCommand = $insertGenreCommand;
        }

        public function execute()
        {
            try {
                $genres = $this->vevo->getGenres()->getDecodedJsonResponse();

                foreach ($genres as $genre) {
                    $this->insertGenreCommand->execute($genre['name']);
                }

            } catch (\Exception $e) {
                // @todo handle
            }
        }
    }

}

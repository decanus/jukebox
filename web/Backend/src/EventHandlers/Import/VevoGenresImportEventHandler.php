<?php

namespace Jukebox\Backend\EventHandlers\Import
{

    use Jukebox\Backend\Commands\InsertGenreCommand;
    use Jukebox\Backend\EventHandlers\EventHandlerInterface;
    use Jukebox\Backend\Services\Vevo;
    use Jukebox\Framework\Logging\Loggers\LoggerInterface;
    use Jukebox\Framework\Logging\LoggingProvider;

    class VevoGenresImportEventHandler implements EventHandlerInterface, LoggerInterface
    {
        /**
         * @trait
         */
        use LoggingProvider;

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
                $this->logCritical($e);
            }
        }
    }

}

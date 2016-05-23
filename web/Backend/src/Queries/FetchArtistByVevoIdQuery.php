<?php

namespace Jukebox\Backend\Queries
{

    use Jukebox\Framework\Backends\PostgreDatabaseBackend;

    class FetchArtistByVevoIdQuery
    {
        /**
         * @var PostgreDatabaseBackend
         */
        private $databaseBackend;

        public function __construct(PostgreDatabaseBackend $databaseBackend)
        {
            $this->databaseBackend = $databaseBackend;
        }

        /**
         * @param $vevoId
         * 
         * @return mixed
         */
        public function execute($vevoId)
        {
            return $this->databaseBackend->fetch(
                'SELECT * FROM artists WHERE vevo_id = :vevo_id',
                [':vevo_id' => $vevoId]
            );
        }
    }
}

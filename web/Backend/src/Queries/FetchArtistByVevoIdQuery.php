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
        
        public function execute($vevoId): mixed
        {
            return $this->databaseBackend->fetchAll(
                'SELECT * FROM artists WHERE vevo_id = :vevo_id',
                [':vevo_id' => $vevoId]
            );
        }
    }
}

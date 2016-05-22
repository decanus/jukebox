<?php

namespace Jukebox\Backend\Queries
{

    use Jukebox\Framework\Backends\PostgreDatabaseBackend;

    class FetchArtistByUrlSafeNameQuery
    {
        /**
         * @var PostgreDatabaseBackend
         */
        private $databaseBackend;

        public function __construct(PostgreDatabaseBackend $databaseBackend)
        {
            $this->databaseBackend = $databaseBackend;
        }
        
        public function execute($urlSafeName): mixed
        {
            return $this->databaseBackend->fetchAll(
                'SELECT * FROM artists WHERE url_safe_name = :url_safe_name',
                [':url_safe_name' => $urlSafeName]
            );
        }
    }
}

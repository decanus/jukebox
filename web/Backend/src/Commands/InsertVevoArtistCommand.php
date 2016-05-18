<?php

namespace Jukebox\Backend\Commands
{

    use Jukebox\Framework\Backends\PostgreDatabaseBackend;
    use Jukebox\Framework\ValueObjects\Uri;

    class InsertVevoArtistCommand
    {
        /**
         * @var PostgreDatabaseBackend
         */
        private $postgreDatabaseBackend;

        public function __construct(PostgreDatabaseBackend $postgreDatabaseBackend)
        {
            $this->postgreDatabaseBackend = $postgreDatabaseBackend;
        }

        public function execute(
            string $artist,
            string $urlSafeName,
            Uri $officialWebsite = null,
            string $twitter = null,
            Uri $facebook = null,
            Uri $itunes = null,
            Uri $amazon = null
        ): bool
        {
            return $this->postgreDatabaseBackend->insert(
                'INSERT INTO artists (name, urlSafeName, isVevo, officialWebsite, twitter, facebook, itunes, amazon) VALUES (:name, :urlSafeName, :isVevo, :officialWebsite, :twitter, :facebook, :itunes, :amazon)',
                [
                    ':name' => $artist,
                    ':urlSafeName' => $urlSafeName,
                    ':isVevo' => true,
                    ':officialWebsite' => (string) $officialWebsite,
                    ':twitter' => $twitter,
                    ':facebook' => (string) $facebook,
                    ':itunes' => (string) $itunes,
                    ':amazon' => (string) $amazon
                ]
            );
        }
    }
}

<?php

namespace Jukebox\Backend\Commands
{

    use Jukebox\Framework\ValueObjects\Uri;

    class InsertArtistCommand extends AbstractDatabaseBackendCommand
    {
        public function execute(
            string $artist,
            string $vevoId = null,
            Uri $officialWebsite = null,
            string $twitter = null,
            Uri $facebook = null,
            Uri $itunes = null,
            Uri $amazon = null
        ): bool
        {
            return $this->getDatabaseBackend()->insert(
                'INSERT INTO artists (name, vevo_id, official_website, twitter, facebook, itunes, amazon) VALUES (:name, :vevo_id, :official_website, :twitter, :facebook, :itunes, :amazon)',
                [
                    ':name' => $artist,
                    ':vevo_id' => $vevoId,
                    ':official_website' => (string) $officialWebsite,
                    ':twitter' => $twitter,
                    ':facebook' => (string) $facebook,
                    ':itunes' => (string) $itunes,
                    ':amazon' => (string) $amazon
                ]
            );
        }
    }
}

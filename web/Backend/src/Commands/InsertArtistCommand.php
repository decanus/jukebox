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
            Uri $amazon = null,
            string $permalink
        ): bool
        {
            return $this->getDatabaseBackend()->execute(
                'INSERT INTO artists (name, vevo_id, official_website, twitter, facebook, itunes, amazon, permalink) VALUES (:name, :vevo_id, :official_website, :twitter, :facebook, :itunes, :amazon, :permalink)',
                [
                    ':name' => $artist,
                    ':vevo_id' => $vevoId,
                    ':official_website' => $officialWebsite,
                    ':twitter' => $twitter,
                    ':facebook' => $facebook,
                    ':itunes' => $itunes,
                    ':amazon' => $amazon,
                    ':permalink' => $permalink
                ]
            );
        }
    }
}

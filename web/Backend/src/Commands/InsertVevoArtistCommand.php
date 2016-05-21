<?php

namespace Jukebox\Backend\Commands
{

    use Jukebox\Framework\ValueObjects\Uri;

    class InsertVevoArtistCommand extends AbstractDatabaseBackendCommand
    {
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
            return $this->getDatabaseBackend()->insert(
                'INSERT INTO artists (name, url_safe_name, is_vevo, official_website, twitter, facebook, itunes, amazon) VALUES (:name, :url_safe_name, :is_vevo, :official_website, :twitter, :facebook, :itunes, :amazon)',
                [
                    ':name' => $artist,
                    ':url_safe_name' => $urlSafeName,
                    ':is_vevo' => true,
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

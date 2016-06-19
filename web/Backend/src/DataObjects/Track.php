<?php

namespace Jukebox\Backend\DataObjects
{
    class Track
    {
        /**
         * @var int
         */
        private $duration;

        /**
         * @var string
         */
        private $title;

        /**
         * @var string
         */
        private $vevoId = null;

        /**
         * @var string
         */
        private $isrc = null;

        /**
         * @var bool
         */
        private $isLive = false;

        /**
         * @var bool
         */
        private $hasLyrics = false;

        /**
         * @var bool
         */
        private $isAudio = false;

        /**
         * @var bool
         */
        private $isOfficial = false;

        /**
         * @var bool
         */
        private $isExplicit = false;

        /**
         * @var string
         */
        private $permalink;

        /**
         * @var \DateTime
         */
        private $releaseDate;

        public function __construct(
            int $duration,
            string $title,
            string $vevoId,
            string $isrc,
            bool $isLive = false,
            bool $hasLyrics = false,
            bool $isAudio = false,
            bool $isOfficial = false,
            bool $isExplicit = false,
            string $permalink,
            \DateTime $releaseDate
        )
        {
            $this->duration = $duration;
            $this->title = $title;
            $this->vevoId = $vevoId;
            $this->isrc = $isrc;
            $this->isLive = $isLive;
            $this->hasLyrics = $hasLyrics;
            $this->isAudio = $isAudio;
            $this->isOfficial = $isOfficial;
            $this->isExplicit = $isExplicit;
            $this->permalink = $permalink;
            $this->releaseDate = $releaseDate;
        }

        public function getDuration(): int
        {
            return $this->duration;
        }

        public function getTitle(): string
        {
            return $this->title;
        }

        public function getVevoId(): string
        {
            return $this->vevoId;
        }

        public function getIsrc(): string
        {
            return $this->isrc;
        }

        public function isLive(): bool
        {
            return $this->isLive;
        }

        public function hasLyrics(): bool
        {
            return $this->hasLyrics;
        }

        public function isAudio(): bool
        {
            return $this->isAudio;
        }

        public function isOfficial(): bool
        {
            return $this->isOfficial;
        }

        public function isExplicit(): bool
        {
            return $this->isExplicit;
        }

        public function getPermalink(): string
        {
            return $this->permalink;
        }

        public function getReleaseDate(): \DateTime
        {
            return $this->releaseDate;
        }

    }
}

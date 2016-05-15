<?php

namespace Jukebox\Framework\ValueObjects
{
    class MetaTags
    {
        /**
         * @var string
         */
        private $title;

        /**
         * @var string
         */
        private $description;

        /**
         * @var string
         */
        private $image = '';

        /**
         * @param string $image
         */
        public function setImage($image)
        {
            $this->image = $image;
        }

        /**
         * @param string $title
         */
        public function setTitle($title)
        {
            $this->title = $title;
        }

        /**
         * @param string $description
         */
        public function setDescription($description)
        {
            $this->description = $description;
        }

        /**
         * @return string
         */
        public function getImage(): string
        {
            return $this->image;
        }

        /**
         * @return string
         */
        public function getTitle(): string
        {
            return $this->title;
        }

        /**
         * @return string
         */
        public function getDescription(): string
        {
            return $this->description;
        }
    }
}

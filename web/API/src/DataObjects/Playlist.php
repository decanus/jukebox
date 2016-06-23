<?php

namespace Jukebox\API\DataObjects
{
    class Playlist
    {
        /**
         * @var string
         */
        private $name;

        /**
         * @var string
         */
        private $owner;

        public function __construct(string $name, string $owner)
        {
            $this->name = $name;
            $this->owner = $owner;
        }

        public function getName(): string
        {
            return $this->name;
        }

        public function getOwner(): string
        {
            return $this->owner;
        }

        public function toArray(): array
        {
            return [
                'name' => $this->getName(),
                'private' => false,
                'description' => null,
                'owner' =>  $this->getOwner()
            ];
        }
    }
}

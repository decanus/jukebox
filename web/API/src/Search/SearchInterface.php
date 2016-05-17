<?php


namespace Jukebox\Search
{
    interface SearchInterface
    {
        public function search(string $query): array;
    }
}

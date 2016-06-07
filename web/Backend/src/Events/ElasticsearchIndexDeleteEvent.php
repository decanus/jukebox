<?php

namespace Jukebox\Backend\Events
{

    use Jukebox\Framework\Events\EventInterface;

    class ElasticsearchIndexDeleteEvent implements EventInterface
    {
        /**
         * @var string
         */
        private $index;

        public function __construct($index)
        {
            $this->index = $index;
        }

        public function getName(): string
        {
            return 'ElasticsearchIndexDelete';
        }

        public function getIndex(): string
        {
            return $this->index;
        }
    }
}

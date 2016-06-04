<?php

namespace Jukebox\Frontend\Models
{

    use Jukebox\Framework\Models\AbstractModel;

    class TrackPageModel extends AbstractModel
    {
        private $track;

        public function setTrack(array $track)
        {
            $this->track = $track;
        }

        public function getTrack(): array 
        {
            return $this->track;
        }
    }
}

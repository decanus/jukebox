<?php

namespace Jukebox\Frontend\Models
{

    use Jukebox\Framework\Models\AbstractModel;

    class AjaxModel extends AbstractModel
    {
        private $data = [];

        public function setData(array $data)
        {
            $this->data = $data;
        }

        public function getData(): array 
        {
            return $this->data;
        }
    }
}

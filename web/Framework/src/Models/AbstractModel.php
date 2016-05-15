<?php

namespace Jukebox\Framework\Models
{

    use Jukebox\Framework\Http\Redirect\AbstractRedirect;
    use Jukebox\Framework\ValueObjects\Uri;

    abstract class AbstractModel
    {
        /**
         * @var Uri
         */
        private $requestUri;

        /**
         * @var AbstractRedirect
         */
        private $redirect;

        /**
         * @var bool
         */
        private $ignorePreviousUri;

        public function __construct(Uri $requestUri, $ignorePreviousUri = false)
        {
            $this->requestUri = $requestUri;
            $this->ignorePreviousUri = $ignorePreviousUri;
        }

        public function getRequestUri(): Uri
        {
            return $this->requestUri;
        }

        public function setRedirect(AbstractRedirect $redirect)
        {
            $this->redirect = $redirect;
        }

        public function getRedirect(): AbstractRedirect
        {
            if (!$this->hasRedirect()) {
                throw new \RuntimeException('No redirect defined');
            }
            
            return $this->redirect;
        }

        public function hasRedirect(): bool
        {
            return $this->redirect instanceof AbstractRedirect;
        }

        public function ignorePreviousUri(): bool
        {
            return $this->ignorePreviousUri;
        }
    }
}

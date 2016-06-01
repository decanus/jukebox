<?php

namespace Jukebox\Framework\ValueObjects
{
    abstract class Token
    {
        /**
         * @var string
         */
        private $tokenValue;
        
        public function __construct(string $token = null)
        {
            if ($token !== null) {
                $this->tokenValue = $token;
            } else {
                $this->setTokenValue();
            }
        }
        
        public function __toString(): string
        {
            return $this->tokenValue;
        }
        
        public function isEqualTo(Token $token): bool
        {
            return $this->tokenValue === (string)$token;
        }
        
        private function setTokenValue()
        {
            $source  = file_get_contents('/dev/urandom', false, null, null, $this->getLength() + 1000);
            $source .= uniqid(uniqid(mt_rand(0, PHP_INT_MAX), true), true);

            for ($t = 0; $t < ($this->getLength() + 1000); $t++) {
                $source .= chr((mt_rand() ^ mt_rand()) % 256);
            }

            for ($length = 0; $length < $this->getLength(); $length++) {
                $currentToken = sha1(hash('sha512', str_shuffle($source), true));
                $this->tokenValue .= $currentToken[rand(0, strlen($currentToken) - 1)];
            }
        }
        
        abstract protected function getLength(): int;
    }
}

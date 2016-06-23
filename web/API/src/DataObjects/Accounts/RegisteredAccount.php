<?php

namespace Jukebox\API\DataObjects\Accounts
{
    class RegisteredAccount implements AccountInterface
    {
        /**
         * @var string
         */
        private $userId;

        public function __construct(string $userId)
        {
            $this->userId = $userId;
        }

        public function getId(): string
        {
            return $this->userId;
        }
    }
}

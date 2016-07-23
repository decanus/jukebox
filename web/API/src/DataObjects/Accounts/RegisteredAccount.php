<?php

namespace Jukebox\API\DataObjects\Accounts
{

    use Jukebox\Framework\ValueObjects\Username;

    class RegisteredAccount implements AccountInterface
    {
        /**
         * @var string
         */
        private $userId;

        /**
         * @var Username
         */
        private $username;

        public function __construct(string $userId, Username $username)
        {
            $this->userId = $userId;
            $this->username = $username;
        }

        public function getId(): string
        {
            return $this->userId;
        }

        public function getUsername(): Username
        {
            return $this->username;
        }
    }
}

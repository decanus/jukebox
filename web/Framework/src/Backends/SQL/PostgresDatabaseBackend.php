<?php

namespace Jukebox\Framework\Backends
{
    class PostgresDatabaseBackend
    {
        /**
         * @var \PDO
         */
        private $PDO;

        public function __construct(PDO $PDO)
        {
            $this->PDO = $PDO;
        }

        public function fetchAll(string $sql, array $parameters = []): mixed
        {
            $statement = $this->PDO->prepare($sql);
            $statement->execute($parameters);

            return $this->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function insert(string $sql, array $parameters = []): bool
        {
            $statement = $this->PDO->prepare($sql);
            return $statement->execute($parameters);
        }
    }
}

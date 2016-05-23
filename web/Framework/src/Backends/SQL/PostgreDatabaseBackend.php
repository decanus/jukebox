<?php

namespace Jukebox\Framework\Backends
{
    class PostgreDatabaseBackend
    {
        /**
         * @var \PDO
         */
        private $PDO;

        public function __construct(PDO $PDO)
        {
            $this->PDO = $PDO;
        }

        public function fetchAll(string $sql, array $parameters = [])
        {
            $statement = $this->PDO->prepare($sql);
            $statement->execute($parameters);

            return $statement->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function fetch(string $sql, array $parameters = [])
        {
            $statement = $this->PDO->prepare($sql);
            $statement->execute($parameters);

            return $statement->fetch(\PDO::FETCH_ASSOC);
        }

        public function insert(string $sql, array $parameters = []): bool
        {
            $statement = $this->PDO->prepare($sql);
            return $statement->execute($parameters);
        }
        
        public function lastInsertId($name = null)
        {
            return $this->PDO->lastInsertId($name);
        }
    }
}

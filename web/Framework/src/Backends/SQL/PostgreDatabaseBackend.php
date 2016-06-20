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
            $statement = $this->prepare($sql);
            $statement->execute($parameters);

            return $statement->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function fetch(string $sql, array $parameters = [])
        {
            $statement = $this->prepare($sql);
            $statement->execute($parameters);

            return $statement->fetch(\PDO::FETCH_ASSOC);
        }

        public function insert(string $sql, array $parameters = []): bool
        {
            $statement = $this->prepare($sql);
            return $statement->execute($parameters);
        }
        
        public function lastInsertId($name = null)
        {
            return $this->PDO->lastInsertId($name);
        }

        public function beginTransaction()
        {
            $this->PDO->beginTransaction();
        }

        public function commit()
        {
            return $this->PDO->commit();
        }

        public function rollBack()
        {
            $this->PDO->rollBack();
        }

        public function inTransaction(): bool
        {
            return $this->PDO->inTransaction();
        }

        public function prepare(string $statement): \PDOStatement
        {
            try {
                return $this->PDO->prepare($statement);
            } catch (\PDOException $e) {
                throw new \Exception('PDO failed to prepare the statement "' . $statement . '"', 0, $e);
            }
        }
    }
}

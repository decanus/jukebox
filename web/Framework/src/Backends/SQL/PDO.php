<?php

namespace Jukebox\Framework\Backends
{
    class PDO
    {
        /**
         * @var \PDO
         */
        private $pdo;

        /**
         * @var string
         */
        private $dsn;

        /**
         * @var string
         */
        private $username;

        /**
         * @var string
         */
        private $password;

        /**
         * @var array
         */
        private $options;

        public function __construct(string $dsn, string $username = '', string  $password = '', array $options = [])
        {
            $this->dsn = $dsn;
            $this->username = $username;
            $this->password = $password;
            $this->options = $options;
        }

        public function __call($name, $arguments)
        {
            $this->connect();
            try {
                if ($name !== 'lastInsertId' && !$this->pdo->inTransaction()) {
                    $this->pdo->query("SELECT 1;")->execute();
                }
            } catch (\PDOException $e) {

                if ($e->getCode() != 'HY000' || !stristr($e->getMessage(), 'server has gone away')) {
                    throw $e;
                }

                $this->reconnect();
            }

            return call_user_func_array(array($this->pdo, $name), $arguments);
        }

        private function connect()
        {
            if ($this->pdo !== null) {
                return;
            }
            
            $this->pdo = new \PDO($this->dsn, $this->username, $this->password, $this->options);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }

        private function reconnect()
        {
            $this->pdo = null;
            $this->connect();
        }
    }
}

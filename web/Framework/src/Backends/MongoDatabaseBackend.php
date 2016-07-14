<?php

namespace Jukebox\Framework\Backends
{

    use Jukebox\Framework\Logging\LoggerAware;
    use Jukebox\Framework\Logging\LoggerAwareTrait;
    use MongoDB\Client;
    use MongoDB\Database;
    use MongoDB\InsertOneResult;
    use MongoDB\Operation\FindOneAndUpdate;
    use MongoDB\UpdateResult;

    class MongoDatabaseBackend implements LoggerAware
    {
        /**
         * @trait
         */
        use LoggerAwareTrait;

        /**
         * @var Client
         */
        private $client;

        /**
         * @var Database
         */
        private $database;

        /**
         * @var string
         */
        private $databaseName;

        /**
         * @param Client $client
         * @param string $databaseName
         */
        public function __construct(Client $client, string $databaseName)
        {
            $this->client = $client;
            $this->databaseName = $databaseName;
        }

        public function find(string $collectionName, array $query, $limit = 0): array
        {
            try {
                $options = [];
                if ($limit !== 0) {
                    $options['limit'] = $limit;
                }


                $result = $this->getDatabase()->selectCollection($collectionName)->find($query, $options);
                $result->setTypeMap(['root' => 'array', 'document' => 'array', 'array' => 'array']);
                return $result->toArray();
            } catch (\Throwable $e) {
                $this->getLogger()->emergency($e);
                throw $e;
            }
        }

        public function findOne(string $collectionName, array $query, array $options = [])
        {
            try {
                return $this->getDatabase()->selectCollection($collectionName)->findOne($query, $options);
            } catch (\Throwable $e) {
                $this->getLogger()->emergency($e);
                throw $e;
            }
        }

        public function findAndModify(string $collectionName, array $query, array $update, $upsert = false)
        {
            try {
                return $this->getDatabase()->selectCollection($collectionName)->findOneAndUpdate(
                    $query,
                    $update,
                    ['upsert' => $upsert, 'returnDocument' => FindOneAndUpdate::RETURN_DOCUMENT_AFTER]
                );
            } catch (\Throwable $e) {
                $this->getLogger()->emergency($e);
                throw $e;
            }
        }
        
        public function updateOne(string $collectionName, array $filter, array $update): UpdateResult
        {
            try {
                return $this->getDatabase()->selectCollection($collectionName)->updateOne($filter, $update);
            } catch (\Throwable $e) {
                $this->getLogger()->emergency($e);
                throw $e;
            }
        }
        
        public function insertOne(string $collectionName, array $document): InsertOneResult
        {
            try {
                return $this->getDatabase()->selectCollection($collectionName)->insertOne($document);
            } catch (\Throwable $e) {
                $this->getLogger()->emergency($e);
                throw $e;
            }
        }

        private function getDatabase()
        {
            try {
                if ($this->database === null) {
                    $this->database = $this->client->selectDatabase($this->databaseName);
                }

                return $this->database;
            } catch (\Throwable $e) {
                $this->getLogger()->emergency($e);
                throw $e;
            }

        }
    }
}

<?php

namespace App\Libraries;

use MongoDB\Client;
use MongoDB\Driver\ServerApi;
use Exception;

class MongoDb
{
    private $client;
    private $database;

    /**
     * Constructor
     */
    public function __construct()
    {
        $uri = 'mongodb+srv://renztayo321:RXzC5tmUk6PUeGJp@cobita.fmexq.mongodb.net/?retryWrites=true&w=majority&appName=CoBITA';

        // Set the version of the Stable API on the client
        $apiVersion = new ServerApi(ServerApi::V1);

        // Create a new client and connect to the server
        $this->client = new Client($uri, [], ['serverApi' => $apiVersion]);

        try {
            // Send a ping to confirm a successful connection
            $this->client->selectDatabase('admin')->command(['ping' => 1]);
            echo "Pinged your deployment. You successfully connected to MongoDB!\n";
        } catch (Exception $e) {
            printf($e->getMessage());
        }

        // Set the database to use
        $this->database = $this->client->selectDatabase('your_database_name');
    }

    /**
     * Create a new document
     *
     * @param string $collection
     * @param array $document
     * @return \MongoDB\InsertOneResult
     */
    public function create(string $collection, array $document)
    {
        return $this->database->selectCollection($collection)->insertOne($document);
    }

    /**
     * Read documents
     *
     * @param string $collection
     * @param array $filter
     * @param array $options
     * @return \MongoDB\Cursor
     */
    public function read(string $collection, array $filter = [], array $options = [])
    {
        return $this->database->selectCollection($collection)->find($filter, $options);
    }

    /**
     * Update documents
     *
     * @param string $collection
     * @param array $filter
     * @param array $update
     * @param array $options
     * @return \MongoDB\UpdateResult
     */
    public function update(string $collection, array $filter, array $update, array $options = [])
    {
        return $this->database->selectCollection($collection)->updateMany($filter, ['$set' => $update], $options);
    }

    /**
     * Delete documents
     *
     * @param string $collection
     * @param array $filter
     * @param array $options
     * @return \MongoDB\DeleteResult
     */
    public function delete(string $collection, array $filter, array $options = [])
    {
        return $this->database->selectCollection($collection)->deleteMany($filter, $options);
    }

    /**
     * Sample method
     *
     * @return string
     */
    public function sampleMethod()
    {
        return 'This is a sample method in the MongoDb library.';
    }
}
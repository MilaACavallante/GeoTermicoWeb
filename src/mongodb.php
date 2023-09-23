<?php

use MongoDB\Client;
use MongoDB\Driver\ServerApi;

global $databaseName, $collectionName;

$databaseName = 'geotermico';
$collectionName = 'dados_sensores';

function connectToMongoDB()
{
    // Replace the placeholder with your Atlas connection string
    $uri = 'mongodb+srv://climageo:awsxcde@clouster1.ntclxl9.mongodb.net/?retryWrites=true&w=majority';
    
    // Specify Stable API version 1
    $apiVersion = new ServerApi(ServerApi::V1);

    // Create a new client and connect to the server
    $client = new Client($uri, [], ['serverApi' => $apiVersion]);

    try {
        // Send a ping to confirm a successful connection
        $client->selectDatabase('admin')->command(['ping' => 1]);
        return $client;
    } catch (Exception $e) {
        printf($e->getMessage());
    }
}

function getAllDocuments()
{    
    global $databaseName, $collectionName;

    $client = connectToMongoDB();
    $database = $client->selectDatabase($databaseName);
    $collection = $database->selectCollection($collectionName);

    $documents = json_decode(json_encode($collection->find()->toArray(), true));    

    $id = $documents[0]->_id->{'$oid'};
    $ip = $documents[0]->{'0'}->IP;
    $dataB = $documents[0]->{'0'}->DATAB;

    $dados = (object) array("id" => $id, "IP" => $ip, "DATAB" => $dataB);
    
    return $dados;
}

function getLastInsertedObject()
{
    global $databaseName, $collectionName;

    $client = connectToMongoDB();
    $collection = $client->$databaseName->$collectionName;

    $options = [
        'sort' => ['_id' => -1],
        'limit' => 1
    ];

    $document = json_decode(json_encode($collection->find([], $options)->toArray(),true));

    if (!empty($document)) {

        $id = $document[0]->_id->{'$oid'};
        $ip = $document[0]->{'0'}->IP;
        $dataB = $document[0]->{'0'}->DATAB;
    
        $dados = (object) array("id" => $id, "IP" => $ip, "DATAB" => $dataB);

        return $dados;
    }

    return null;
}

function getDocumentIdFromCollection()
{
    global $databaseName, $collectionName;

    $client = connectToMongoDB();
    $database = $client->selectDatabase($databaseName);
    $collection = $database->selectCollection($collectionName);


    $document = $collection->findOne();

    if ($document) {
        return (string) $document->_id;
    }

    return null;
}

function findDocumentById($id)
{
    global $databaseName, $collectionName;

    $client = connectToMongoDB();
    $database = $client->selectDatabase($databaseName);
    $collection = $database->selectCollection($collectionName);

    try {
        $filter = ['_id' => new MongoDB\BSON\ObjectID($id)];
        $document = $collection->findOne($filter);
        return $document;
    } catch (Exception $e) {
        printf($e->getMessage());
        return null;
    }
}

function updateDocument($id, $update)
{
    global $databaseName, $collectionName;

    $client = connectToMongoDB();
    $database = $client->selectDatabase($databaseName);
    $collection = $database->selectCollection($collectionName);
    $options = ['upsert' => true];

    try {
        $filter = ['_id' => new MongoDB\BSON\ObjectID($id)];
        $collection->updateOne($filter, $update, $options);
        return true;
    } catch (Exception $e) {
        printf($e->getMessage());
        return false;
    }
}


function insertDocument($document)
{
    global $databaseName, $collectionName;

    $client = connectToMongoDB();
    $database = $client->selectDatabase($databaseName);
    $collection = $database->selectCollection($collectionName);

    try {
        $insertResult = $collection->insertOne($document);
        return $insertResult->getInsertedId()->jsonSerialize()['$oid'];
    } catch (Exception $e) {
        printf($e->getMessage());
    }
    return null;
}

function hasDocuments()
{
    global $databaseName, $collectionName;

    $client = connectToMongoDB();
    $database = $client->selectDatabase($databaseName);
    $collection = $database->selectCollection($collectionName);

    $count = $collection->countDocuments();

    return $count > 0;
}
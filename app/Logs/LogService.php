<?php

namespace App\Logs;

use MongoDB\Client;
use Illuminate\Support\Carbon;
use MongoDB\BSON\ObjectId;

class LogService
{
    private $collection;

    public function __construct()
    {
        $client = new Client("mongodb://" . env('MONGO_DB_HOST') . ":" . env('MONGO_DB_PORT'));

        $db = $client->selectDatabase(env('MONGO_DB_DATABASE', 'logs_db'));
        $this->collection = $db->logs;
    }

    public function log(string $message): void
    {
        $this->collection->insertOne([
            'message' => $message,
            'timestamp' => Carbon::now()->toDateTimeString(),
        ]);
    }

    public function getLogs(?string $id = null)
    {
        if ($id) {
            return $this->collection->findOne(['_id' => new ObjectId($id)]);
        }

        // Retorna últimos 30 logs
        return $this->collection->find([], ['limit' => 30, 'sort' => ['timestamp' => -1]])->toArray();
    }
}

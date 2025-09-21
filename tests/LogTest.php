<?php

use App\Logs\LogService;
use MongoDB\Client;
use Tests\TestCase;

class LogTest extends TestCase
{
    protected LogService $logService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->logService = app(LogService::class);

        $client = new Client("mongodb://mongodb:27017");
        $client->selectDatabase('logs_test')->logs->deleteMany([]);
    }

    public function testCreateLog()
    {
        $this->logService->log('Log de teste');
        $logs = $this->logService->getLogs();
        $this->assertCount(1, $logs);
        $this->assertEquals('Log de teste', $logs[0]['message']);
    }

    public function testGetLogById()
    {
        $this->logService->log('Log único');
        $logs = $this->logService->getLogs();
        $id = (string)$logs[0]['_id'];

        $log = $this->logService->getLogs($id);
        $this->assertEquals('Log único', $log['message']);
    }
}

<?php

use App\Models\Task;
use Tests\TestCase;
use MongoDB\Client;
use Laravel\Lumen\Testing\DatabaseMigrations;

class TaskTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate');

        $client = new Client("mongodb://mongodb:27017");
        $client->selectDatabase('logs_test')->logs->deleteMany([]);
    }


    public function testListTasksEmpty()
    {
        $this->get('/api/tasks');

        $this->seeStatusCode(200);

        $this->seeJson(['status' => 'success']);
    }

    public function testCreateTask()
    {
        $payload = [
            'title' => 'Test Task',
            'description' => 'Descrição',
            'status' => 'pending'
        ];

        $this->post('/api/tasks', $payload, ['Accept' => 'application/json']);

        $this->seeStatusCode(201);

        $this->seeJson(['title' => 'Test Task']);
    }

    public function testGetTaskById()
    {
        $task = Task::create([
            'title' => 'Get Task',
            'description' => 'Test',
            'status' => 'pending'
        ]);

        $this->get("/api/tasks/{$task->id}");
        $this->seeStatusCode(200);
        $this->seeJson(['title' => 'Get Task']);
    }

    public function testUpdateTask()
    {
        $task = Task::create([
            'title' => 'Old Title',
            'description' => 'Old',
            'status' => 'pending'
        ]);

        $payload = ['title' => 'New Title', 'status' => 'done'];
        $this->put("/api/tasks/{$task->id}", $payload, ['Accept' => 'application/json']);
        $this->seeStatusCode(200);
        $this->seeJson(['title' => 'New Title']);
    }

    public function testDeleteTask()
    {
        $task = Task::create([
            'title' => 'Delete Me',
            'description' => 'Test',
            'status' => 'pending'
        ]);

        $this->delete("/api/tasks/{$task->id}");
        $this->seeStatusCode(200);

        $this->notSeeInDatabase('tasks', ['id' => $task->id]);
    }
}

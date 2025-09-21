<?php

namespace App\Services;

use App\Repositories\Contracts\TaskRepositoryInterface;
use App\Logs\LogService;
use App\Models\Task;

class TaskService
{
    public function __construct(
        private TaskRepositoryInterface $repository,
        private LogService $logService
    ) {}

    public function getAll(?string $status = null)
    {
        return $this->repository->all($status);
    }

    public function getById(int $id): ?Task
    {
        return $this->repository->find($id);
    }

    public function create(array $data): Task
    {
        $task = $this->repository->create($data);
        $this->logService->log("Task {$task->id} criada");
        return $task;
    }

    public function update(Task $task, array $data): Task
    {
        $task = $this->repository->update($task, $data);
        $this->logService->log("Task {$task->id} atualizada");
        return $task;
    }

    public function delete(Task $task): bool
    {
        $this->logService->log("Task {$task->id} removida");
        return $this->repository->delete($task);
    }
}

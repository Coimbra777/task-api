<?php

namespace App\Repositories\Contracts;

use App\Models\Task;

interface TaskRepositoryInterface
{
    public function all(?string $status = null);
    public function find(int $id): ?Task;
    public function create(array $data): Task;
    public function update(Task $task, array $data): Task;
    public function delete(Task $task): bool;
}

<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $service;

    public function __construct(TaskService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $mapping = [
            'pendente' => 'pending',
            'em_progresso' => 'in_progress',
            'concluida' => 'done'
        ];

        $status = $request->query('status');

        if ($status && isset($mapping[$status])) {
            $status = $mapping[$status];
        }

        if ($status && !in_array($status, ['pending', 'in_progress', 'done'])) {
            return ApiResponse::error("Status inválido.", 422);
        }

        $tasks = $this->service->getAll($status);

        return ApiResponse::success(TaskResource::collection($tasks));
    }

    public function show($id)
    {
        $task = $this->service->getById($id);
        if (!$task) {
            return ApiResponse::error('Task not found', 404);
        }
        return ApiResponse::success(TaskResource::format($task));
    }

    public function store(Request $request)
    {
        $data = TaskRequest::validate($request);
        $task = $this->service->create($data);
        return ApiResponse::success(TaskResource::format($task), 'Task created', 201);
    }

    public function update(Request $request, $id)
    {
        $task = $this->service->getById($id);
        if (!$task) {
            return ApiResponse::error('Task not found', 404);
        }

        $data = TaskRequest::validate($request);
        $task = $this->service->update($task, $data);

        return ApiResponse::success(TaskResource::format($task), 'Task updated');
    }

    public function destroy($id)
    {
        $task = $this->service->getById($id);
        if (!$task) {
            return ApiResponse::error('Task not found', 404);
        }

        $this->service->delete($task);
        return ApiResponse::success(null, 'Task deleted');
    }
}

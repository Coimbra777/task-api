<?php

namespace App\Http\Resources;

use App\Models\Task;

class TaskResource
{
    public static function format(Task $task): array
    {
        return [
            'id' => $task->id,
            'title' => $task->title,
            'description' => $task->description,
            'status' => $task->status,
            'created_at' => $task->created_at,
            'updated_at' => $task->updated_at,
        ];
    }

    public static function collection($tasks): array
    {
        return $tasks->map(fn($task) => self::format($task))->toArray();
    }
}

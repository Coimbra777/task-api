<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TaskRequest
{
    public static function validate(Request $request): array
    {
        // Mapeamento português → inglês
        $mapping = [
            'pendente' => 'pending',
            'em_progresso' => 'in_progress',
            'concluida' => 'done'
        ];

        $input = $request->all();

        if (isset($input['status']) && isset($mapping[$input['status']])) {
            $input['status'] = $mapping[$input['status']];
        }

        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|in:pending,in_progress,done',
        ];

        $messages = [
            'status.in' => 'The selected status is invalid.'
        ];

        $validator = app('validator')->make($input, $rules, $messages);

        if ($validator->fails()) {
            throw new ValidationException($validator, response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()->all()
            ], 422));
        }

        return $validator->validated();
    }
}

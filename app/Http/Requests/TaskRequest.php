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

        if (isset($input['status'])) {
            $input['status'] = $mapping[$input['status']] ?? $input['status'];
        } else {
            $input['status'] = 'pending';
        }

        $rules = [
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:pending,in_progress,done',
        ];

        $messages = [
            'status.in' => 'O status selecionado é inválido. Deve ser: pendente, em_progresso ou concluida.',
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

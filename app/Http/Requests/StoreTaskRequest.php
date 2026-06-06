<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name_task' => 'required|string|max:255',
            'description' =>'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date'
        ];
    }

    public function messages():array{
        return[
            'name_task.required'=> 'Le nom de la tâche est obligatoire',
            'name_task.max'=> 'Le nom de la tâche ne doit pas dépasser 255 caractères',
            'due_date.date'=> 'la date doit être valide'
        ];
    }
}

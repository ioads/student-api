<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMatriculaRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'aluno_id' => 'required|exists:alunos,id',
            'curso_id' => 'required|exists:cursos,id',
            'data_matricula' => 'required|date',
            'status' => 'required|string|in:pendente,confirmada,cancelada',
            'observacoes' => 'nullable|string|max:255',
        ];
    }
}

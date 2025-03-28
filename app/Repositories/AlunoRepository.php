<?php

namespace App\Repositories;

use App\Models\Aluno;
use App\Repositories\AlunoRepositoryInterface;

class AlunoRepository implements AlunoRepositoryInterface
{
    protected Aluno $model;

    public function __construct(Aluno $aluno)
    {
        $this->model = $aluno;
    }

    public function all($request)
    {
        $alunos = $this->model->query();

        if ($request->has('email')) {
            $alunos->where('email', 'like', '%' . $request->input('email') . '%');
        }

        if ($request->has('nome')) {
            $alunos->where('nome', 'like', '%' . $request->input('nome') . '%');
        }

        $alunos = $alunos->with('matriculas', 'matriculas.curso')->get();

        return response()->json($alunos, 200);
    }

    public function find($id)
    {
        $aluno = $this->model->find($id);
        if(!$aluno) {
            return response()->json(['message' => 'Aluno não encontrado'], 404);
        }

        return response()->json($aluno, 200);
    }

    public function create(array $data)
    {
        $aluno = $this->model->create($data);
 
        return response()->json($aluno, 201);
    }

    public function update($id, array $data)
    {
        $aluno = $this->model->find($id);
        if (!$aluno) {
            return response()->json(['message' => 'Aluno não encontrado'], 404);
        }

        $aluno->update($data);

        return response()->json($aluno, 200);
    }

    public function delete($id)
    {
        $aluno = $this->model->find($id);
        if (!$aluno) {
            return response()->json(['message' => 'Aluno não encontrado'], 404);
        }

        $aluno->delete();

        return response()->json(['message' => 'Aluno excluído com sucesso'], 200);
    }
}
<?php

namespace App\Repositories;

use App\Models\Curso;
use App\Repositories\CursoRepositoryInterface;

class CursoRepository implements CursoRepositoryInterface
{
    protected Curso $model;

    public function __construct(Curso $curso)
    {
        $this->model = $curso;
    }

    public function all()
    {
        $cursos = $this->model->all();
        return response()->json($cursos, 200);
    }

    public function find($id)
    {
        $curso = $this->model->find($id);
        if(!$curso) {
            return response()->json(['message' => 'Curso não encontrado'], 404);
        }

        return response()->json($curso, 200);
    }

    public function create(array $data)
    {
        $curso = $this->model->create($data);
 
        return response()->json($curso, 201);
    }

    public function update($id, array $data)
    {
        $curso = $this->model->find($id);
        if (!$curso) {
            return response()->json(['message' => 'Curso não encontrado'], 404);
        }

        $curso->update($data);

        return response()->json($curso, 200);
    }

    public function delete($id)
    {
        $curso = $this->model->find($id);
        if (!$curso) {
            return response()->json(['message' => 'Curso não encontrado'], 404);
        }

        $curso->delete();

        return response()->json(['message' => 'Curso excluído com sucesso'], 200);
    }
}
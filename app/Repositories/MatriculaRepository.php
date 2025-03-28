<?php

namespace App\Repositories;

use App\Models\Matricula;
use App\Repositories\MatriculaRepositoryInterface;

class MatriculaRepository implements MatriculaRepositoryInterface
{
    protected Matricula $model;

    public function __construct(Matricula $matricula)
    {
        $this->model = $matricula;
    }

    public function all()
    {
        $matriculas = $this->model->all();
        return response()->json($matriculas, 200);
    }

    public function find($id)
    {
        $matricula = $this->model->find($id);
        if(!$matricula) {
            return response()->json(['message' => 'Matrícula não encontrado'], 404);
        }

        return response()->json($matricula, 200);
    }

    public function create(array $data)
    {
        $matricula = $this->model->create($data);
 
        return response()->json($matricula, 201);
    }

    public function update($id, array $data)
    {
        $matricula = $this->model->find($id);
        if (!$matricula) {
            return response()->json(['message' => 'Matrícula não encontrado'], 404);
        }

        $matricula->update($data);

        return response()->json($matricula, 200);
    }

    public function delete($id)
    {
        $matricula = $this->model->find($id);
        if (!$matricula) {
            return response()->json(['message' => 'Matrícula não encontrado'], 404);
        }

        $matricula->delete();

        return response()->json(['message' => 'Matrícula excluído com sucesso'], 200);
    }
}
<?php

namespace App\Repositories;

use App\Models\Aluno;
use App\Models\Matricula;
use App\Repositories\AlunoRepositoryInterface;
use Illuminate\Support\Facades\DB;

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

    public function alunosPorFaixaEtaria()
    {
        $faixasEtarias = [
            'menor_que_15' => [0, 14],
            'entre_15_e_18' => [15, 18],
            'entre_19_e_24' => [19, 24],
            'entre_25_e_30' => [25, 30],
            'maior_que_30' => [31, 999],
        ];
    
        $result = [];
    
        foreach ($faixasEtarias as $key => $faixa) {
            $result[$key] = Matricula::selectRaw('
                    matriculas.curso_id, 
                    cursos.titulo as curso_titulo, 
                    alunos.sexo, 
                    count(*) as total
                ')
                ->join('alunos', 'alunos.id', '=', 'matriculas.aluno_id')
                ->join('cursos', 'cursos.id', '=', 'matriculas.curso_id')
                ->whereBetween(DB::raw('TIMESTAMPDIFF(YEAR, alunos.data_nascimento, CURDATE())'), $faixa)
                ->groupBy('matriculas.curso_id', 'alunos.sexo', 'cursos.titulo')
                ->get()
                ->map(function ($item) {
                    return [
                        'curso_id' => $item->curso_id,
                        'curso_titulo' => $item->curso_titulo,
                        'sexo' => $item->sexo,
                        'total' => $item->total,
                    ];
                });
        }
    
        return response()->json($result, 200);
    }
}
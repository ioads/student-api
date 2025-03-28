<?php

use App\Models\Aluno;

class AlunoRepository
{
    protected $model;

    public function __construct(Aluno $aluno)
    {
        $this->model = $aluno;
    }

    public function getAll()
    {
        return $this->model->all();
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    protected $table = 'alunos';

    protected $fillable = [
        'nome',
        'email',
        'sexo',
        'data_nascimento',
    ];

    public function matriculas()
    {
        return $this->hasMany(Matricula::class, 'aluno_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $table = 'cursos';

    protected $fillable = [
        'titulo',
        'descricao'
    ];

    public function matriculas()
    {
        return $this->hasMany(Matricula::class, 'curso_id');
    }
}

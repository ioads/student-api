<?php

namespace App\Http\Controllers;

use AlunoRepository;

class AlunoController extends Controller
{
    protected $AlunoRepository;

    public function __construct(AlunoRepository $alunoRepository)
    {
        $this->AlunoRepository = $alunoRepository;
    }

    public function index()
    {
        return $this->AlunoRepository->getAll();
    }
}

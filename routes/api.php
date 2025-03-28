<?php

use App\Http\Controllers\AlunoController;
use App\Http\Controllers\CursoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('alunos', AlunoController::class);
Route::apiResource('cursos', CursoController::class);

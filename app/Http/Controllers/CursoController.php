<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCursoRequest;
use App\Http\Requests\UpdateCursoRequest;
use App\Repositories\CursoRepository;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    protected $cursoRepository;

    public function __construct(CursoRepository $cursoRepository)
    {
        $this->cursoRepository = $cursoRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->cursoRepository->all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCursoRequest $request)
    {
        return $this->cursoRepository->create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->cursoRepository->find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCursoRequest $request, string $id)
    {
        return $this->cursoRepository->update($id, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->cursoRepository->delete($id);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMatriculaRequest;
use App\Http\Requests\UpdateMatriculaRequest;
use App\Repositories\MatriculaRepository;

class MatriculaController extends Controller
{
    protected $matriculaRepository;

    public function __construct(MatriculaRepository $matriculaRepository)
    {
        $this->matriculaRepository = $matriculaRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->matriculaRepository->all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMatriculaRequest $request)
    {
        return $this->matriculaRepository->create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->matriculaRepository->find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMatriculaRequest $request, string $id)
    {
        return $this->matriculaRepository->update($id, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->matriculaRepository->delete($id);
    }
}

<?php

namespace App\Repositories;

interface AlunoRepositoryInterface
{
    public function all($request);
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
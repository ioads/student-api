<?php

namespace Tests\Unit;

use App\Models\Aluno;
use App\Models\Matricula;
use App\Repositories\AlunoRepository;
use Illuminate\Http\Request;
use Tests\TestCase;
use Mockery;

class AlunoControllerTest extends TestCase
{
    /**
     * Testa a filtragem por email no método index().
     *
     * @return void
     */
    public function test_index_filtra_por_email()
    {
        $request = Mockery::mock(Request::class);
        $request->shouldReceive('has')->with('email')->andReturn(true);
        $request->shouldReceive('input')->with('email')->andReturn('aluno@exemplo.com');

        $aluno = Mockery::mock(Aluno::class);
        $aluno->shouldReceive('jsonSerialize')->andReturn([
            'nome' => 'João',
            'email' => 'aluno@exemplo.com'
        ]);

        $alunoRepository = Mockery::mock(AlunoRepository::class);
        $alunoRepository->shouldReceive('all')->andReturn(
            response()->json([$aluno], 200)
        );

        $controller = new \App\Http\Controllers\AlunoController($alunoRepository);

        $response = $controller->index($request);

        $this->assertEquals(200, $response->getStatusCode());

        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals('aluno@exemplo.com', $responseData[0]['email']);
    }

    /**
     * Testa a filtragem por nome no método index().
     *
     * @return void
     */
    public function test_index_filtra_por_nome()
    {
        $request = Mockery::mock(Request::class);
        $request->shouldReceive('has')->with('nome')->andReturn(true);
        $request->shouldReceive('input')->with('nome')->andReturn('João');

        $aluno = Mockery::mock(Aluno::class);
        $aluno->shouldReceive('jsonSerialize')->andReturn([
            'nome' => 'João',
            'email' => 'joao@exemplo.com'
        ]);

        $alunoRepository = Mockery::mock(AlunoRepository::class);
        $alunoRepository->shouldReceive('all')->andReturn(
            response()->json([$aluno], 200)
        );

        $controller = new \App\Http\Controllers\AlunoController($alunoRepository);

        $response = $controller->index($request);

        $this->assertEquals(200, $response->getStatusCode());

        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals('João', $responseData[0]['nome']);
    }

    /**
     * Testa a inclusão do relacionamento matriculas e curso no método index().
     *
     * @return void
     */
    public function test_index_inclui_relacionamento_matriculas_e_curso()
    {
        $request = Mockery::mock(Request::class);
        $request->shouldReceive('has')->andReturn(false);

        $curso = Mockery::mock('App\Models\Curso');
        $curso->shouldReceive('jsonSerialize')->andReturn([
            'id' => 1,
            'titulo' => 'Curso de Testes',
        ]);

        $matricula = Mockery::mock(Matricula::class);
        $matricula->shouldReceive('jsonSerialize')->andReturn([
            'aluno_id' => 1,
            'curso_id' => 1,
            'data_matricula' => '2023-03-28',
            'status' => 'ativo',
            'observacoes' => 'Observação qualquer',
            'curso' => $curso->jsonSerialize(),
        ]);

        $aluno = Mockery::mock(Aluno::class);
        $aluno->shouldReceive('jsonSerialize')->andReturn([
            'nome' => 'João',
            'email' => 'joao@exemplo.com',
            'matriculas' => [$matricula->jsonSerialize()]
        ]);

        $alunoRepository = Mockery::mock(AlunoRepository::class);
        $alunoRepository->shouldReceive('all')->andReturn(
            response()->json([$aluno], 200)
        );

        $controller = new \App\Http\Controllers\AlunoController($alunoRepository);

        $response = $controller->index($request);

        $this->assertEquals(200, $response->getStatusCode());

        $responseData = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('nome', $responseData[0]);
        $this->assertArrayHasKey('email', $responseData[0]);
        $this->assertArrayHasKey('matriculas', $responseData[0]);
        $this->assertIsArray($responseData[0]['matriculas']);
        $this->assertArrayHasKey('curso', $responseData[0]['matriculas'][0]);
        $this->assertArrayHasKey('id', $responseData[0]['matriculas'][0]['curso']);
        $this->assertArrayHasKey('titulo', $responseData[0]['matriculas'][0]['curso']);
    }

    /**
     * Testa a criação de um novo aluno.
     *
     * @return void
     */
    public function test_store_cria_novo_aluno()
    {
        $request = Mockery::mock(\App\Http\Requests\StoreAlunoRequest::class);
        $request->shouldReceive('all')->andReturn([
            'nome' => 'Maria Silva',
            'email' => 'maria@exemplo.com',
            'data_nascimento' => '2000-01-01',
            'sexo' => 'feminino'
        ]);

        $aluno = Mockery::mock(Aluno::class);
        $aluno->shouldReceive('jsonSerialize')->andReturn([
            'id' => 1,
            'nome' => 'Maria Silva',
            'email' => 'maria@exemplo.com',
            'data_nascimento' => '2000-01-01',
            'sexo' => 'feminino'
        ]);
        $aluno->shouldReceive('toJson')->andReturn(json_encode([
            'id' => 1,
            'nome' => 'Maria Silva',
            'email' => 'maria@exemplo.com',
            'data_nascimento' => '2000-01-01',
            'sexo' => 'feminino'
        ]));

        $alunoRepository = Mockery::mock(AlunoRepository::class);
        $alunoRepository->shouldReceive('create')->with($request->all())->andReturn(
            response()->json($aluno, 201)
        );

        $controller = new \App\Http\Controllers\AlunoController($alunoRepository);

        $response = $controller->store($request);

        $this->assertEquals(201, $response->getStatusCode());

        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals('Maria Silva', $responseData['nome']);
        $this->assertEquals('maria@exemplo.com', $responseData['email']);
        $this->assertEquals('2000-01-01', $responseData['data_nascimento']);
        $this->assertEquals('feminino', $responseData['sexo']);
    }

    /**
     * Testa a exclusão de um aluno.
     *
     * @return void
     */
    public function test_destroy_remove_aluno()
    {
        $alunoId = 1;

        $alunoRepository = Mockery::mock(AlunoRepository::class);
        $alunoRepository->shouldReceive('delete')->with($alunoId)->andReturn(
            response()->json(['message' => 'Aluno excluído com sucesso'], 200)
        );

        $controller = new \App\Http\Controllers\AlunoController($alunoRepository);

        $response = $controller->destroy($alunoId);

        $this->assertInstanceOf(\Illuminate\Http\JsonResponse::class, $response);
        
        $this->assertEquals(200, $response->getStatusCode());

        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals('Aluno excluído com sucesso', $responseData['message']);
    }
}

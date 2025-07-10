<?php

namespace App\Http\Controllers;

use App\Models\Pessoa;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Pessoas
 * Gerenciamento de pessoas.
 */
class PessoaController extends Controller
{
    /**
     * Lista todas as pessoas cadastradas.
     *
     * Retorna todos os registros de pessoas no banco.
     *
     * @response 200 [
     *   {
     *     "id": 1,
     *     "nome": "João Silva",
     *     "cpf": "12345678900",
     *     "telefone": "11999999999"
     *   }
     * ]
     * @response 200 {
     *   "message": "Não existem pessoas cadastradas"
     * }
     */
    public function index() {
        $pessoa = Pessoa::all();

        if ($pessoa->isEmpty()) {
            return response()->json(['message' => 'Não existem pessoas cadastradas'], 200);
        }

        return response()->json($pessoa);
    }

    /**
     * Cadastra uma nova pessoa.
     *
     * Cria um novo registro com nome, CPF e telefone.
     *
     * @bodyParam nome string required Nome completo da pessoa. Ex: João Silva
     * @bodyParam cpf string required CPF válido e único. Ex: 12345678900
     * @bodyParam telefone string required Telefone de contato. Ex: 11999999999
     *
     * @response 201 {
     *   "message": "Pessoa incluída com sucesso"
     * }
     * @response 422 {
     *   "errors": {
     *     "cpf": ["Já existe uma pessoa cadastrada com este CPF."]
     *   }
     * }
     */
    public function store(Request $request) {
        $validated = $request->validate([
            'nome'     => 'required|string',
            'cpf'      => 'required|string|unique:pessoas,cpf',
            'telefone' => 'required|string',
        ], [
            'cpf.unique' => 'Já existe uma pessoa cadastrada com este CPF.',
        ]);

        Pessoa::create($validated);

        return response()->json(['message' => 'Pessoa incluída com sucesso'], 201);
    }

    /**
     * Consulta uma pessoa pelo ID.
     *
     * Retorna os dados de uma pessoa com base no ID informado.
     *
     * @urlParam id integer required ID da pessoa. Ex: 1
     * 
     * @response 200 {
     *   "id": 1,
     *   "nome": "João Silva",
     *   "cpf": "12345678900",
     *   "telefone": "11999999999"
     * }
     * @response 404 {
     *   "message": "Pessoa não encontrada"
     * }
     */
    public function show($id) {
        if (!$pessoa = Pessoa::find($id)) {
            return response()->json(['message' => 'Pessoa não encontrada'], 404);
        }

        return response()->json($pessoa);
    }

    /**
     * Atualiza os dados de uma pessoa.
     *
     * Modifica os dados de nome, CPF e/ou telefone da pessoa com o ID informado.
     *
     * @urlParam id integer required ID da pessoa. Ex: 1
     * @bodyParam nome string Nome completo. Ex: Maria Oliveira
     * @bodyParam cpf string CPF único. Ex: 12345678911
     * @bodyParam telefone string Telefone de contato. Ex: 11988887777
     *
     * @response 200 {
     *   "message": "Pessoa alterada com sucesso"
     * }
     * @response 404 {
     *   "message": "Pessoa não encontrada, dados não alterados"
     * }
     */
    public function update(Request $request, $id) {
        if (!$pessoa = Pessoa::find($id)) {
            return response()->json(['message' => 'Pessoa não encontrada, dados não alterados'], 404);
        }

        $validated = $request->validate([
            'nome'     => 'sometimes|required|string',
            'cpf'      => "sometimes|required|string|unique:pessoas,cpf,{$id}",
            'telefone' => 'sometimes|required|string',
        ]);

        $pessoa->update($validated);

        return response()->json(['message' => 'Pessoa alterada com sucesso'], 200);
    }

    /**
     * Exclui uma pessoa pelo ID.
     *
     * Remove o registro da pessoa correspondente ao ID.
     *
     * @urlParam id integer required ID da pessoa. Ex: 1
     *
     * @response 200 {
     *   "message": "Pessoa excluída com sucesso"
     * }
     * @response 404 {
     *   "message": "Pessoa não encontrada, registro não excluído"
     * }
     */
    public function destroy($id) {
        if (!$pessoa = Pessoa::find($id)) {
            return response()->json(['message' => 'Pessoa não encontrada, registro não excluído'], 404);
        }

        $pessoa->delete();

        return response()->json(['message' => 'Pessoa excluída com sucesso'], 200);
    }
}
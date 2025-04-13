<?php

namespace App\Http\Controllers;

use App\Models\Pessoa;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PessoaController extends Controller
{
    /**
     * Consulta todas as pessoas cadastradas.
     * @return Collection<int, static>
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
     * @param Request $request  
     * @return JsonResponse
     */
    public function store(Request $request) {
        $validated = $request->validate([
            'nome'     => 'required|string',
            'cpf'      => 'required|string|unique:pessoas,cpf',
            'telefone' => 'required|string',
        ]);

        Pessoa::create($validated);

        return response()->json(['message' => 'Pessoa incluída com sucesso'], 201);
    }

    /**
     * Consulta a pessoa com o id informado.
     * @param integer $id
     * @return JsonResponse
     */
    public function show($id) {
        if (!$pessoa = Pessoa::find($id)) {
            return response()->json(['message' => 'Pessoa não encontrada'], 404);
        }

        return response()->json($pessoa);
    }

    /**
     * Atualiza os dados da pessoa com o id informado.
     * @param Request $request
     * @param integer $id
     * @return JsonResponse
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
     * Exclui um cadastro de pessoa.
     * @param integer $id
     * @return JsonResponse
     */
    public function destroy($id) {
        if (!$pessoa = Pessoa::find($id)) {
            return response()->json(['message' => 'Pessoa não encontrada, registro não excluído'], 404);
        }

        $pessoa->delete();

        return response()->json(['message' => 'Pessoa excluída com sucesso'], 200);
    }
}
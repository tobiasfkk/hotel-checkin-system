<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Reservas
 * Gerenciamento de reservas.
 */
class ReservaController extends Controller
{
    /**
     * @group Reservas
     * Lista todas as reservas cadastradas.
     *
     * Retorna todas as reservas com os dados da pessoa associada.
     *
     * @response 200 {
     *    [
     *      {
     *        "id": 1,
     *        "idPessoa": 2,
     *        "numeroQuarto": 101,
     *        "dataHoraInicio": "2025-07-12T14:00:00",
     *        "dataHoraFim": "2025-07-14T12:00:00",
     *        "pessoa": {
     *          "id": 2,
     *          "nome": "João da Silva",
     *          "cpf": "000.000.000-00",
     *          "telefone": "(11) 99999-0000"
     *        }
     *      }
     *    ]
     * }
     */
    public function index(): JsonResponse
    {
        $reservas = Reserva::with('pessoa')->get();

        if ($reservas->isEmpty()) {
            return response()->json(['message' => 'Nenhuma reserva encontrada'], 200);
        }

        return response()->json($reservas);
    }

    /**
     * @group Reservas
     * Cadastra uma nova reserva.
     *
     * Verifica se o quarto está disponível nas datas informadas antes de cadastrar.
     *
     * @bodyParam idPessoa integer required ID da pessoa. Example: 1
     * @bodyParam numeroQuarto integer required Número do quarto. Example: 203
     * @bodyParam dataHoraInicio datetime required Data/hora de entrada. Example: 2025-07-15 14:00:00
     * @bodyParam dataHoraFim datetime required Data/hora de saída. Example: 2025-07-17 12:00:00
     *
     * @response 201 {
     *   "message": "Reserva criada com sucesso"
     * }
     * @response 422 {
     *   "message": "O quarto não está disponível para as datas selecionadas"
     * }
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'idPessoa'       => 'required|exists:pessoas,id',
            'numeroQuarto'   => 'required|integer|min:1',
            'dataHoraInicio' => 'required|date|after_or_equal:today',
            'dataHoraFim'    => 'required|date|after:dataHoraInicio',
        ]);

        if (!(new Reserva())->isQuartoDisponivel($validated['numeroQuarto'], $validated['dataHoraInicio'], $validated['dataHoraFim'])) {
            return response()->json([
                'message' => 'O quarto não está disponível para as datas selecionadas'
            ], 422);
        }

        Reserva::create($validated);

        return response()->json(['message' => 'Reserva criada com sucesso'], 201);
    }


    /**
     * @group Reservas
     * Exibe uma reserva específica.
     *
     * Retorna a reserva com os dados da pessoa associada.
     *
     * @urlParam id integer required ID da reserva. Example: 1
     * 
     * @response 200 {
     *   "id": 1,
     *   "idPessoa": 1,
     *   "numeroQuarto": 203,
     *   "dataHoraInicio": "2025-07-15T14:00:00",
     *   "dataHoraFim": "2025-07-17T12:00:00",
     *   "pessoa": { ... }
     * }
     * @response 404 {
     *   "message": "Reserva não encontrada"
     * }
     */
    public function show($id) {
        $reserva = Reserva::with('pessoa')->find($id);

        if (!$reserva) {
            return response()->json(['message' => 'Reserva não encontrada'], 404);
        }

        return response()->json($reserva);
    }

    /**
     * @group Reservas
     * Atualiza uma reserva.
     *
     * Verifica disponibilidade antes de atualizar.
     *
     * @urlParam id integer required ID da reserva. Example: 1
     * @bodyParam numeroQuarto integer Número do quarto. Example: 203
     * @bodyParam dataHoraInicio datetime Data/hora de entrada. Example: 2025-07-15 14:00:00
     * @bodyParam dataHoraFim datetime Data/hora de saída. Example: 2025-07-17 12:00:00
     *
     * @response 200 {
     *   "message": "Reserva atualizada com sucesso"
     * }
     * @response 422 {
     *   "message": "O quarto não está disponível para as datas selecionadas"
     * }
     */
    public function update(Request $request, $id) {
        $reserva = Reserva::find($id);

        if (!$reserva) {
            return response()->json(['message' => 'Reserva não encontrada'], 404);
        }

        $validated = $request->validate([
            'numeroQuarto'   => 'sometimes|required|integer|min:1',
            'dataHoraInicio' => 'sometimes|required|date',
            'dataHoraFim'    => 'sometimes|required|date|after:dataHoraInicio',
        ]);

        if (!(new Reserva())->isQuartoDisponivel($validated['numeroQuarto'], $validated['dataHoraInicio'], $validated['dataHoraFim'])) {
            return response()->json([
                'message' => 'O quarto não está disponível para as datas selecionadas'
            ], 422);
        }

        $reserva->update($validated);

        return response()->json(['message' => 'Reserva atualizada com sucesso'], 200);
    }

    /**
     * @group Reservas
     * Exclui uma reserva.
     *
     * @urlParam id integer required ID da reserva. Example: 1
     * 
     * @response 200 {
     *   "message": "Reserva excluída com sucesso"
     * }
     * @response 404 {
     *   "message": "Reserva não encontrada, registro não excluído"
     * }
     */
    public function destroy($id) {
        if (!$reserva = Reserva::find($id)) {
            return response()->json(['message' => 'Reserva não encontrada, registro não excluído'], 404);
        }

        $reserva->delete();

        return response()->json(['message' => 'Reserva excluída com sucesso'], 200);
    }
}
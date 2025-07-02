<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    /**
     * Lista todas as reservas cadastradas.
     * @return JsonResponse
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
     * Cadastra uma nova reserva.
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'idPessoa'       => 'required|exists:pessoas,id',
            'numeroQuarto'   => 'required|integer|min:1',
            'dataHoraInicio' => 'required|date|after_or_equal:today',
            'dataHoraFim'    => 'required|date|after:dataHoraInicio',
        ]);

        Reserva::create($validated);

        return response()->json(['message' => 'Reserva criada com sucesso'], 201);
    }

    /**
     * Exibe uma reserva específica.
     * @param integer $id
     * @return JsonResponse
     */
    public function show($id) {
        $reserva = Reserva::with('pessoa')->find($id);

        if (!$reserva) {
            return response()->json(['message' => 'Reserva não encontrada'], 404);
        }

        return response()->json($reserva);
    }

    /**
     * Atualiza uma reserva.
     * @param Request $request
     * @param integer $id
     * @return JsonResponse
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

        $reserva->update($validated);

        return response()->json(['message' => 'Reserva atualizada com sucesso'], 200);
    }

    /**
     * Exclui um cadastro de Reserva.
     * @param integer $id
     * @return JsonResponse
     */
    public function destroy($id) {
        if (!$reserva = Reserva::find($id)) {
            return response()->json(['message' => 'Reserva não encontrada, registro não excluído'], 404);
        }

        $reserva->delete();

        return response()->json(['message' => 'Reserva excluída com sucesso'], 200);
    }
}
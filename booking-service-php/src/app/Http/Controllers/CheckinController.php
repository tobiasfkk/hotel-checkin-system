<?php

namespace App\Http\Controllers;

use App\Models\Checkin;
use App\Models\Reserva;
use DateTime;
use Illuminate\Http\Request;

/**
 * @group Check-ins
 * Gerenciamento de entradas de hóspedes.
 */
class CheckinController extends Controller
{
    /**
     * @group Check-ins
     * Lista todos os check-ins cadastrados.
     *
     * Retorna todos os check-ins com as reservas associadas.
     *
     * @response 200 {
     *   [
     *     {
     *       "id": 1,
     *       "reserva_id": 1,
     *       "dataHoraEntrada": "2025-07-10T14:00:00",
     *       "garagem": 1,
     *       "reserva": {
     *         "id": 1,
     *         "numeroQuarto": 101,
     *         "dataHoraInicio": "2025-07-10T14:00:00",
     *         "dataHoraFim": "2025-07-12T12:00:00"
     *       }
     *     }
     *   ]
     * }
     */
    public function index()
    {
        $checkins = Checkin::with('reserva')->get();

        if ($checkins->isEmpty()) {
            return response()->json(['message' => 'Nenhum check-in encontrado'], 200);
        }

        return response()->json($checkins);
    }

    /**
     * @group Check-ins
     * Cadastra um novo check-in.
     *
     * Verifica se a data de entrada está dentro do período da reserva.
     *
     * @bodyParam reserva_id integer required ID da reserva associada. Example: 1
     * @bodyParam dataHoraEntrada datetime required Data e hora do check-in. Example: 2025-07-10 14:00:00
     * @bodyParam garagem integer required Indica se usará garagem: 0 (não), 1 (sim), 2 (vago). Example: 1
     *
     * @response 201 {
     *   "message": "Check-in criado com sucesso"
     * }
     * @response 422 {
     *   "message": "A data de check-in deve estar entre o início e final da Reserva"
     * }
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reserva_id'      => 'required|exists:reservas,id',
            'dataHoraEntrada' => 'required|date',
            'garagem'         => 'required|integer|min:0|max:2',
        ]);

        $reserva = Reserva::find($validated['reserva_id']);

        if (!$reserva) {
            return response()->json(['message' => 'Reserva não encontrada'], 404);
        }

        if (!(new Checkin())->isDataHoraEntradaValida($validated['dataHoraEntrada'], $reserva->dataHoraInicio, $reserva->dataHoraFim)) {
            return response()->json([
                'message' => 'A data de check-in deve estar entre o início e final da Reserva'
            ], 422);
        }

        Checkin::create($validated);

        return response()->json(['message' => 'Check-in criado com sucesso'], 201);
    }

    /**
     * @group Check-ins
     * Exibe um check-in específico.
     *
     * Mostra os dados do check-in com a reserva e o checkout vinculados.
     *
     * @urlParam reservaId integer required ID do check-in. Example: 1
     *
     * @response 200 {
     *   "id": 1,
     *   "reserva_id": 1,
     *   "dataHoraEntrada": "2025-07-10T14:00:00",
     *   "garagem": 1,
     *   "reserva": { ... },
     *   "checkout": { ... }
     * }
     * @response 404 {
     *   "message": "Check-in não encontrado"
     * }
     */
    public function show($reservaId)
    {
        $checkin = Checkin::with('reserva', 'checkout')->find($reservaId);

        if (!$checkin) {
            return response()->json(['message' => 'Check-in não encontrado'], 404);
        }

        return response()->json($checkin);
    }

    /**
     * @group Check-ins
     * Atualiza um check-in.
     *
     * Permite modificar os dados do check-in.
     *
     * @urlParam reservaId integer required ID do check-in. Example: 1
     * @bodyParam reserva_id integer ID da reserva associada. Example: 1
     * @bodyParam dataHoraEntrada datetime Data e hora do check-in. Example: 2025-07-10 14:00:00
     * @bodyParam garagem integer Indica se usará garagem: 0 (não), 1 (sim), 2 (vago). Example: 2
     *
     * @response 200 {
     *   "message": "Check-in atualizado com sucesso"
     * }
     * @response 404 {
     *   "message": "Check-in não encontrado"
     * }
     */
    public function update(Request $request, $reservaId)
    {
        $checkin = Checkin::find($reservaId);

        if (!$checkin) {
            return response()->json(['message' => 'Check-in não encontrado'], 404);
        }

        $validated = $request->validate([
            'reserva_id'      => 'sometimes|required|exists:reservas,id',
            'dataHoraEntrada' => 'sometimes|required|date',
            'garagem'         => 'sometimes|required|integer|min:0|max:2',
        ]);

        $checkin->update($validated);

        return response()->json(['message' => 'Check-in atualizado com sucesso', 200]);
    }

    /**
     * @group Check-ins
     * Exclui um check-in.
     *
     * Remove permanentemente um registro de check-in.
     *
     * @urlParam reservaId integer required ID do check-in. Example: 1
     *
     * @response 200 {
     *   "message": "Check-in excluído com sucesso"
     * }
     * @response 404 {
     *   "message": "Check-in não encontrado, registro não excluído"
     * }
     */
    public function destroy($reservaId)
    {
        if (!$checkin = Checkin::find($reservaId)) {
            return response()->json(['message' => 'Check-in não encontrado, registro não excluído'], 404);
        }

        $checkin->delete();

        return response()->json(['message' => 'Check-in excluído com sucesso'], 200);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Checkin;
use App\Models\Reserva;
use DateTime;
use Illuminate\Http\Request;

class CheckinController extends Controller
{
    /**
     * Lista todos os check-ins cadastrados.
     * @return JsonResponse
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
     * Cadastra um novo check-in.
     * @param Request $request
     * @return JsonResponse
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
     * Exibe um check-in específico.  
     * @param integer $reservaId
     * @return JsonResponse
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
     * Atualiza um check-in.
     * @param Request $request
     * @param integer $reservaId
     * @return JsonResponse
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
     * Exclui um cadastro de Check-in.
     * @param integer $reservaId
     * @return JsonResponse
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

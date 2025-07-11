<?php

namespace App\Http\Controllers;

use App\Models\Checkin;
use App\Models\Checkout;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

/**
 * @group Check-outs
 * Gerenciamento de saídas de hóspedes.
 */
class CheckoutController extends Controller
{
    /**
     * Lista todos os check-outs cadastrados.
     *
     * @response 200 [
     *   {
     *     "id": 1,
     *     "checkin_id": 1,
     *     "dataHoraSaida": "2025-07-11 12:00:00",
     *     "valor": 300.00,
     *     "checkin": {
     *       "id": 1,
     *       "reserva_id": 1,
     *       "dataHoraEntrada": "2025-07-10 14:00:00",
     *       "garagem": 1
     *     }
     *   }
     * ]
     */
    public function index()
    {
        $checkouts = Checkout::with('checkin')->get();

        if ($checkouts->isEmpty()) {
            return response()->json(['message' => 'Nenhum check-out encontrado'], 200);
        }
        
        return response()->json($checkouts);
    }

    /**
     * Cadastra um novo check-out.
     *
     * Calcula o valor automaticamente com base na permanência e uso de garagem.
     *
     * @bodyParam checkin_id integer required ID do check-in relacionado. Example: 1
     * @bodyParam dataHoraSaida datetime required Data e hora da saída. Example: 2025-07-11 12:00:00
     *
     * @response 201 {
     *   "message": "Check-out criado com sucesso",
     *   "checkout": {
     *     "checkin_id": 1,
     *     "dataHoraSaida": "2025-07-11 12:00:00",
     *     "valor": 300.00
     *   }
     * }
     * @response 422 {
     *   "message": "A data de check-out não pode ser anterior à data de check-in"
     * }
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'checkin_id'    => 'required|exists:checkins,reserva_id',
            'dataHoraSaida' => 'required|date'
        ]);

        $checkin = Checkin::where('reserva_id', $validated['checkin_id'])->first();

        if (!$checkin) {
            return response()->json(['message' => 'Check-in não encontrado'], 404);
        }

        if (!(new Checkout())->isDataHoraSaidaValida($validated['dataHoraSaida'], $checkin->dataHoraEntrada)) {
            return response()->json([
                'message' => 'A data de check-out não pode ser anterior à data de check-in'
            ], 422);
        }

        $valor    = (new Checkout())->calcularValorCheckout($checkin->dataHoraEntrada, $validated['dataHoraSaida'], $checkin->garagem);
        $checkout = Checkout::create([
            'checkin_id'    => $validated['checkin_id'],
            'dataHoraSaida' => $validated['dataHoraSaida'],
            'valor'         => $valor
        ]);

        return response()->json(['message' => 'Check-out criado com sucesso', 'checkout' => $checkout], 201);
    }

    /**
     * Exibe um check-out específico.
     *
     * Retorna os dados do check-out com o check-in associado.
     *
     * @urlParam checkinId integer required ID do check-out. Example: 1
     * @response 200 {
     *   "id": 1,
     *   "checkin_id": 1,
     *   "dataHoraSaida": "2025-07-11 12:00:00",
     *   "valor": 300.00,
     *   "checkin": { ... }
     * }
     * @response 404 {
     *   "message": "Check-out não encontrado"
     * }
     */
    public function show($checkinId)
    {
        $checkout = Checkout::with('checkin')->find($checkinId);

        if (!$checkout) {
            return response()->json(['message' => 'Check-out não encontrado'], 404);
        }

        return response()->json($checkout);
    }

    /**
     * Atualiza um check-out.
     *
     * Permite editar manualmente o valor, data ou o check-in relacionado.
     *
     * @urlParam checkinId integer required ID do check-out. Example: 1
     * @bodyParam checkin_id integer ID do check-in relacionado. Example: 2
     * @bodyParam dataHoraSaida datetime Data e hora da saída. Example: 2025-07-12 10:00:00
     * @bodyParam valor number Valor manual do check-out. Example: 400.00
     *
     * @response 200 {
     *   "message": "Check-out atualizado com sucesso"
     * }
     * @response 404 {
     *   "message": "Check-out não encontrado"
     * }
     */
    public function update(Request $request, $checkinId)
    {
        $checkout = Checkout::find($checkinId);
        
        if (!$checkout) {
            return response()->json(['message' => 'Check-out não encontrado'], 404);
        }

        $validated = $request->validate([
            'checkin_id'    => 'sometimes|required|exists:checkins,id',
            'dataHoraSaida' => 'sometimes|required|date',
            'valor'         => 'sometimes|required|numeric|min:0',
        ]);

        $checkout->update($validated);

        return response()->json(['message' => 'Check-out atualizado com sucesso'], 200);
    }

    /**
     * Exclui um cadastro de check-out.
     *
     * @urlParam checkinId integer required ID do check-out. Example: 1
     * @response 200 {
     *   "message": "Check-out excluído com sucesso"
     * }
     * @response 404 {
     *   "message": "Check-out não encontrado, registro não excluído"
     * }
     */
    public function destroy($checkinId)
    {
        if (!$checkout = Checkout::find($checkinId)) {
            return response()->json(['message' => 'Check-out não encontrado, registro não excluído'], 404);
        }

        $checkout->delete();

        return response()->json(['message' => 'Check-out excluído com sucesso'], 200);
    }
}
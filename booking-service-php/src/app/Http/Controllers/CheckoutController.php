<?php

namespace App\Http\Controllers;

use App\Models\Checkin;
use App\Models\Checkout;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CheckoutController extends Controller
{
    /**
     * Lista todos os check-outs cadastrados.
     * @return JsonResponse
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
     * @param Request $request
     * @return JsonResponse
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
     * @param integer $checkinId
     * @return JsonResponse
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
     * @param Request $request
     * @param integer $checkinId
     * @return JsonResponse
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
     * Exclui um cadastro de Check-out.
     * @param integer $checkinId
     * @return JsonResponse
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

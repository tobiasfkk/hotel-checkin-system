<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Checkout extends Model
{
    use HasFactory;

    protected $table        = 'checkouts';
    protected $primaryKey   = 'checkin_id';
    public    $incrementing = false;

    protected $fillable = [
        'checkin_id',
        'dataHoraSaida',
        'valor',
    ];

    public $timestamps = false;

    public function checkin()
    {
        return $this->belongsTo(Checkin::class, 'checkin_id', 'reserva_id');
    }

    /**
     * Verifica se a data e hora de saída do check-out é válida em relação à data e hora de entrada do check-in.
     * @param string $dataHoraSaida
     * @param string $dataHoraEntrada
     * @return bool
     */
    public function isDataHoraSaidaValida(string $dataHoraSaida, string $dataHoraEntrada): bool
    {
        $saida   = new DateTime($dataHoraSaida);
        $entrada = new DateTime($dataHoraEntrada);

        return $saida >= $entrada;
    }

    /**
     * Calcula o valor total do checkout com base na data de entrada, data de saída e número de vagas na garagem.
     * @param  string $dataHoraEntrada
     * @param  string $dataHoraSaida
     * @param  int $vagasGaragem
     * @return float
     * @throws \Exception
     */
    public function calcularValorCheckout(string $dataHoraEntrada, string $dataHoraSaida, int $vagasGaragem): float
    {
        $entrada = new DateTime($dataHoraEntrada);
        $saida   = new DateTime($dataHoraSaida);
        $dados   = [
            'pessoaId'     => 1, // @todo remover após ajuste na api billing. 
            'dataEntrada'  => $entrada->format('Y-m-d\TH:i:s'),
            'dataSaida'    => $saida->format('Y-m-d\TH:i:s'),
            'vagasGaragem' => $vagasGaragem
        ];

        $response = Http::post('http://billing-service:8083/api/billing', $dados);
        
        if ($response->failed()) {
            throw new \Exception('Erro ao calcular valor da estadia: ' . $response->body());
        }
        
        return $response->json('valorTotal');
    }
}

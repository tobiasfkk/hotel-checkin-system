<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkin extends Model
{
    use HasFactory;

    protected $table        = 'checkins';
    protected $primaryKey   = 'reserva_id';
    public    $incrementing = false;

    protected $fillable = [
        'reserva_id',
        'dataHoraEntrada',
        'garagem',
    ];

    public $timestamps = false;

    public function reserva()
    {
        return $this->belongsTo(Reserva::class);
    }

    public function checkout()
    {
        return $this->hasOne(Checkout::class);
    }

    /**
     * Verifica se a data e hora de entrada do check-in é válida em relação ao início e fim da reserva.
     * @param string $dataHoraEntrada
     * @param string $dataHoraInicio
     * @param string $dataHoraFim
     * @return bool 
     */
    public function isDataHoraEntradaValida(string $dataHoraEntrada, string $dataHoraInicio, string $dataHoraFim):bool 
    {
        $entrada        = new DateTime($dataHoraEntrada);
        $inicioReserva  = new DateTime($dataHoraInicio);
        $fimReserva     = new DateTime($dataHoraFim);

        return $entrada >= $inicioReserva && $entrada < $fimReserva;
    }
}

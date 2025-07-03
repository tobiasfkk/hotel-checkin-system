<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    protected $table = 'reservas';

    protected $fillable = [
        'idPessoa',
        'numeroQuarto',
        'dataHoraInicio',
        'dataHoraFim',
    ];

    public $timestamps = false;

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'idPessoa');
    }

    public function checkin()
    {
        return $this->hasOne(Checkin::class);
    }

    /**
     * Verifica se o quarto está disponível para reserva.
     * @param int $numeroQuarto
     * @param string $dataHoraInicio
     * @param string $dataHoraFim
     * @return bool
     */
    public function isQuartoDisponivel(int $numeroQuarto, string $dataHoraInicio, string $dataHoraFim): bool
    {
        $reservas = Reserva::where('numeroQuarto', $numeroQuarto)
            ->where(function ($query) use ($dataHoraInicio, $dataHoraFim) {
                $query->whereBetween('dataHoraInicio', [$dataHoraInicio, $dataHoraFim])
                      ->orWhereBetween('dataHoraFim', [$dataHoraInicio, $dataHoraFim]);
            })
            ->exists();

        return !$reservas;
    }
}
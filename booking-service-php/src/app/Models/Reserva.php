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
}